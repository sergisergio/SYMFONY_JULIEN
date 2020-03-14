<?php

namespace App\Repository;

use App\Entity\Advert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AdvertRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Advert::class);
    }

    // public function getPublishedWithPagination(int $page, int $limit)
    // {
    //     $offset = ($page - 1) * $limit;
    //     return $this->createQueryBuilder('a')
    //         ->where('a.published = :published')
    //         ->setParameter('published', true)
    //         ->orderBy('a.id', 'ASC')
    //         ->setMaxResults($limit)
    //         ->setFirstResult($offset)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
}
