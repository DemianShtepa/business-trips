<?php

declare(strict_types=1);

namespace App\Domain\Trip\Repository;

use App\Domain\Employee\Entity\Employee;
use DateTimeImmutable;

interface TripRepository
{
    public function checkTripIntersection(Employee $employee, DateTimeImmutable $start, DateTimeImmutable $end): bool;
    public function getAllForEmployee(Employee $employee): array;
}
