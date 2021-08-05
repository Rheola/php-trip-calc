<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RouteRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RouteRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method RouteRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method RouteRequest[]    findAll()
 * @method RouteRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RouteRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RouteRequest::class);
    }
}
