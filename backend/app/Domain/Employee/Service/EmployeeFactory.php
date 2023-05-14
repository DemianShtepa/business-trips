<?php

declare(strict_types=1);

namespace App\Domain\Employee\Service;

use App\Domain\Employee\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

final class EmployeeFactory
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(): Employee
    {
        $employee = new Employee();

        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        return $employee;
    }
}
