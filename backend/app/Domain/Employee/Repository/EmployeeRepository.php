<?php

declare(strict_types=1);

namespace App\Domain\Employee\Repository;

use App\Domain\Employee\Entity\Employee;

interface EmployeeRepository
{
    public function getById(int $id): Employee;
}
