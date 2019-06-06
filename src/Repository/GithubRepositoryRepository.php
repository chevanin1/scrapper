<?php

namespace App\Repository;

use App\Entity\GithubRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GithubRepositoryRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method GithubRepositoryRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method GithubRepositoryRepository[]    findAll()
 * @method GithubRepositoryRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GithubRepositoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GithubRepository::class);
    }
}
