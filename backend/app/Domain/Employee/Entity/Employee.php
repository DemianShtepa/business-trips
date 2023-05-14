<?php

declare(strict_types=1);

namespace App\Domain\Employee\Entity;

class Employee
{
    private ?int $id;

    public function __construct()
    {
        $this->id = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
