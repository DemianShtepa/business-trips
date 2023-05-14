<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Employee\Repository\EmployeeRepository as EmployeeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

final class EmployeeRepository extends EntityRepository implements EmployeeRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Employee::class));
    }

    public function getById(int $id): Employee
    {
        /** @var Employee|null $employee */
        $employee = $this->findOneBy(['id' => $id]);
        if ($employee) {
            return $employee;
        }

        throw new EntityNotFoundException('Employee not found');
    }
}
