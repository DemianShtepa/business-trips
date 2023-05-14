<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Trip\Entity\Trip;
use App\Domain\Trip\Repository\TripRepository as TripRepositoryInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class TripRepository extends EntityRepository implements TripRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Trip::class));
    }

    public function checkTripIntersection(Employee $employee, DateTimeImmutable $start, DateTimeImmutable $end): bool
    {
        $query = $this->createQueryBuilder('trips');
        $query
            ->where($query->expr()->eq('trips.employee', ':employee'))
            ->andWhere($query->expr()->orX(
                $query->expr()->andX(
                    $query->expr()->lte('trips.start', ':start'),
                    $query->expr()->gte('trips.end', ':start')
                ),
                $query->expr()->andX(
                    $query->expr()->lte('trips.start', ':end'),
                    $query->expr()->gte('trips.end', ':end')
                ),
                $query->expr()->andX(
                    $query->expr()->gte('trips.start', ':start'),
                    $query->expr()->lte('trips.end', ':end')
                )
            ))
            ->setParameter(':employee', $employee)
            ->setParameter(':start', $start)
            ->setParameter(':end', $end)
            ->setMaxResults(1);

        return (bool)$query->getQuery()->getResult();
    }

    public function getAllForEmployee(Employee $employee): array
    {
        return $this->findBy(['employee' => $employee]);
    }
}
