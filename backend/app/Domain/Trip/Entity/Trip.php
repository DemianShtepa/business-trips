<?php

declare(strict_types=1);

namespace App\Domain\Trip\Entity;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Trip\Enum\Country;
use App\Domain\Trip\ValueObject\PerDiem;
use DateTimeImmutable;

class Trip
{
    private ?int $id;
    private DateTimeImmutable $start;
    private DateTimeImmutable $end;
    private Country $country;
    private PerDiem $perDiem;
    private Employee $employee;

    public function __construct(
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        Country $country,
        PerDiem $perDiem,
        Employee $employee
    ) {
        $this->id = null;
        $this->start = $start;
        $this->end = $end;
        $this->country = $country;
        $this->perDiem = $perDiem;
        $this->employee = $employee;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getPerDiem(): PerDiem
    {
        return $this->perDiem;
    }
}
