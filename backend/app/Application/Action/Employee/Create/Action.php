<?php

declare(strict_types=1);

namespace App\Application\Action\Employee\Create;

use App\Domain\Employee\Service\EmployeeFactory;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

final class Action
{
    private ResponseFactory $responseFactory;
    private EmployeeFactory $employeeFactory;

    public function __construct(
        ResponseFactory $responseFactory,
        EmployeeFactory $employeeFactory
    ) {
        $this->responseFactory = $responseFactory;
        $this->employeeFactory = $employeeFactory;
    }

    public function __invoke(): JsonResponse
    {
        return $this->responseFactory->json(
            ['id' => $this->employeeFactory->create()->getId()]
        );
    }
}
