<?php

declare(strict_types=1);

namespace App\Application\Action\Trip\All;

use App\Domain\Employee\Repository\EmployeeRepository;
use App\Domain\Trip\Entity\Trip;
use App\Domain\Trip\Repository\TripRepository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

final class Action
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    private ResponseFactory $responseFactory;
    private TripRepository $tripRepository;
    private EmployeeRepository $employeeRepository;

    public function __construct(
        ResponseFactory $responseFactory,
        TripRepository $tripRepository,
        EmployeeRepository $employeeRepository
    ) {
        $this->responseFactory = $responseFactory;
        $this->tripRepository = $tripRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $employee = $this->employeeRepository->getById($request->getEmployeeId());

        return $this->getResponse($this->tripRepository->getAllForEmployee($employee));
    }

    private function getResponse(array $trips): JsonResponse
    {
        $formattedTrips = [];

        /** @var Trip $trip */
        foreach ($trips as $trip) {
            $formattedTrips[] = [
                'start' => $trip->getStart()->format(self::DATETIME_FORMAT),
                'end' => $trip->getEnd()->format(self::DATETIME_FORMAT),
                'country' => $trip->getCountry()->value,
                'amount_due' => $trip->getPerDiem()->getAmount(),
                'currency' => $trip->getPerDiem()->getCurrency(),
            ];
        }

        return $this->responseFactory->json($formattedTrips);
    }
}
