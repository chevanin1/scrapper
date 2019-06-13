<?php

namespace App\Command;

use App\Entity\GithubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class GetRepositoriesCommand extends Command
{
    protected static $defaultName = 'app:get-repositories';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Getting Github repositories and their owners and save its to DB')
            ->addArgument('search-word', InputArgument::REQUIRED, 'Word to search')
            ->addOption('start-page', 'p', InputArgument::OPTIONAL, 'Start page', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $searchWord = $input->getArgument('search-word');

        $io->title('Searching by "' . $searchWord . '"');

        $httpClient = HttpClient::create();

        $page = $input->getOption('start-page') ?? 1;
        $reposCount = $_SERVER['APP_GITHUB_REP_SEARCH_PER_PAGE'] * $page;

        $progressBar = new ProgressBar($output, $reposCount);
        $progressBar->start();
        $progressBar->advance(($page - 1) * $_SERVER['APP_GITHUB_REP_SEARCH_PER_PAGE']);
        try {
            while ($page <= ceil($reposCount / $_SERVER['APP_GITHUB_REP_SEARCH_PER_PAGE'])) {
                $response = $httpClient->request('GET',
                    $_SERVER['APP_GITHUB_REP_SEARCH_URL'] . '?q=' . $searchWord .
                    '&page=' . $page . '&per_page=' . $_SERVER['APP_GITHUB_REP_SEARCH_PER_PAGE'] . '&sort=stars'
                );
                /** @var ResponseInterface $pageContent */
                $pageContent = $response->toArray();
                if ($response->getStatusCode() === 200) {
                    $reposCount = $pageContent['total_count'];
                    foreach ($pageContent['items'] as $item) {
                        $repository = $this->entityManager
                            ->getRepository(GithubRepository::class)
                            ->findOneBy(['github_id' => $item['id']]);

                        if ($repository === null) {
                            $repository = new GithubRepository();
                        }

                        $repository->setForks($item['forks']);
                        $repository->setFullName($item['full_name']);
                        $repository->setGithubId($item['id']);
                        $repository->setOwnerGithubId($item['owner']['id']);
                        $repository->setOwnerGithubApiUrl($item['owner']['url']);
                        $repository->setUrl($item['html_url']);
                        $repository->setLanguage($item['language']);
                        $repository->setScore($item['score']);
                        $repository->setOwnerLoaded(false);

                        $this->entityManager->persist($repository);
                    }
                    $progressBar->setMaxSteps($reposCount);
                    $progressBar->advance($_SERVER['APP_GITHUB_REP_SEARCH_PER_PAGE']);
                    $this->entityManager->flush();
                    $page++;
                }
            }
        } catch (Throwable $exception) {
            throw new RuntimeException();
        }

        $progressBar->finish();
        $io->success('All repos from Github was loaded!');
    }
}
