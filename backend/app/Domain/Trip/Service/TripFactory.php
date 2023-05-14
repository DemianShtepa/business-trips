<?php

declare(strict_types=1);

namespace App\Domain\Trip\Service;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Trip\Entity\Trip;
use App\Domain\Trip\Enum\Country;
use App\Domain\Trip\Enum\Currency;
use App\Domain\Trip\Exception\TripIntersectionException;
use App\Domain\Trip\Repository\TripRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final class TripFactory
{
    private TripRepository $tripRepository;
    private PerDiemFactory $perDiemFactory;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TripRepository $tripRepository,
        PerDiemFactory $perDiemFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->tripRepository = $tripRepository;
        $this->perDiemFactory = $perDiemFactory;
        $this->entityManager = $entityManager;
    }

    public function create(
        Employee $employee,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        Country $country,
        Currency $currency = Currency::PLN
    ): Trip {
        if ($this->tripRepository->checkTripIntersection($employee, $start, $end)) {
            throw new TripIntersectionException();
        }

        $perDiem = $this->perDiemFactory->create($country, $currency, $start, $end);
        $trip = new Trip(
            $start,
            $end,
            $country,
            $perDiem,
            $employee
        );

        $this->entityManager->persist($trip);
        $this->entityManager->flush();

        return $trip;
    }
}
