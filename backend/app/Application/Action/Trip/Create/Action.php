<?php

declare(strict_types=1);

namespace App\Application\Action\Trip\Create;

use App\Domain\Employee\Repository\EmployeeRepository;
use App\Domain\Trip\Exception\TripException;
use App\Domain\Trip\Service\TripFactory;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class Action
{
    private ResponseFactory $responseFactory;
    private EmployeeRepository $employeeRepository;
    private TripFactory $tripFactory;

    public function __construct(
        ResponseFactory $responseFactory,
        EmployeeRepository $employeeRepository,
        TripFactory $tripFactory
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->responseFactory = $responseFactory;
        $this->tripFactory = $tripFactory;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $employee = $this->employeeRepository->getById($request->getEmployeeId());

        try {
            $trip = $this->tripFactory->create(
                $employee,
                $request->getStart(),
                $request->getEnd(),
                $request->getCountry()
            );
        } catch (TripException $exception) {
            return $this->responseFactory->json(
                ['message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->responseFactory->json(
            [
                'id' => $trip->getId()
            ],
            Response::HTTP_CREATED
        );
    }
}
