<?php

declare(strict_types=1);

namespace App\Application\Providers;

use App\Domain\Employee\Repository\EmployeeRepository as EmployeeRepositoryInterface;
use App\Domain\Trip\Repository\TripRepository as TripRepositoryInterface;
use App\Infrastructure\Repository\EmployeeRepository;
use App\Infrastructure\Repository\TripRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->app->get(EntityManagerInterface::class);

        $this->app->instance(
            TripRepositoryInterface::class,
            new TripRepository($entityManager),
        );
        $this->app->instance(
            EmployeeRepositoryInterface::class,
            new EmployeeRepository($entityManager),
        );
    }
}
