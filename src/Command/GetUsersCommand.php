<?php

namespace App\Command;

use App\Entity\GithubOwner;
use App\Entity\GithubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class GetUsersCommand extends Command
{
    protected static $defaultName = 'app:get-users';
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
        $this->setDescription('Getting Github users by parsed repositories and save its to DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Getting Github repos owners');

        $githubRepos = $this->entityManager
            ->getRepository(GithubRepository::class)
            ->findBy(['owner' => null]);

        $httpClient = HttpClient::create();
        $progressBar = new ProgressBar($output, count($githubRepos));
        $progressBar->start();
        try {
            foreach ($githubRepos as $githubRepo) {
                /** @var GithubRepository $githubRepo */
                $response = $httpClient->request('GET', $githubRepo->getOwnerGithubApiUrl());

                if ($response->getStatusCode() === 200) {
                    /** @var ResponseInterface $pageContent */
                    $item = $response->toArray();

                    /** @var GithubOwner $githubOwner */
                    $githubOwner = $this->entityManager->getRepository(GithubOwner::class)
                        ->findOneBy(['github_id' => $item['id']]);

                    if ($githubOwner === null) {
                        $githubOwner = new GithubOwner();
                    }

                    $githubOwner->setGithubId($item['id']);
                    $githubOwner->setBio($item['bio']);
                    $githubOwner->setUrl($item['html_url']);
                    $githubOwner->setType($item['type']);
                    $githubOwner->setName($item['name']);
                    $githubOwner->setCompany(trim($item['company'] . ' ' . $item['blog']));
                    $githubOwner->setLocation($item['location']);
                    $githubOwner->setEmail($item['email']);
                    $githubOwner->setPublicRepos($item['public_repos']);

                    $githubRepo->setOwner($githubOwner);

                    $this->entityManager->persist($githubOwner);
                    $this->entityManager->persist($githubRepo);

                    $progressBar->advance(1);
                    $this->entityManager->flush();
                }
            }
        } catch (Throwable $exception) {
            throw new RuntimeException($exception->getMessage());
        }

        $progressBar->finish();

        $io->success('All owners from Github was loaded!');
    }
}
