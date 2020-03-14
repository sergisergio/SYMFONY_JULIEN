<?php

namespace App\Repository;

use \DateTime;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * My personnal findAll()
     */
    public function recupTous()
    {
        return $this->createQueryBuilder('e')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return all event between two dates
     * 
     * @param DateTime $int : START DATE
     * @param DateTime $out : STOP DATE
     * @param int $limit : SQL LIMIT VALUE
     */
    public function findBetweenDate(DateTime $int, DateTime $out, int $limit)
    {
        return $this->createQueryBuilder('e')
            ->where('e.date > :int')
            ->andWhere('e.date < :out')
            ->setParameter('int', $int->format('Y-m-d'))
            ->setParameter('out', $out->format('Y-m-d'))
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return first event
     */
    public function findFirstDate()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return last event
     */
    public function findLastDate()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return all event in specific months
     * 
     * @todo composer require beberlei/DoctrineExtensions
     * 
     * @see https://simukti.net/blog/2012/04/05/how-to-select-year-month-day-in-doctrine2/
     */
    public function findByMonths(array $months)
    {
        $config = $this->getEntityManager()->getConfiguration();
        $config->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        return $this->createQueryBuilder('e')
            ->where('MONTH(e.date) IN (:months)')
            ->setParameter('months', $months)
            ->getQuery()
            ->getResult()
        ;
    }
}
