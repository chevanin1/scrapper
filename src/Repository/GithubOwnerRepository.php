<?php

namespace App\Repository;

use App\Entity\GithubOwner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GithubOwner|null find($id, $lockMode = null, $lockVersion = null)
 * @method GithubOwner|null findOneBy(array $criteria, array $orderBy = null)
 * @method GithubOwner[]    findAll()
 * @method GithubOwner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GithubOwnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GithubOwner::class);
    }
}
