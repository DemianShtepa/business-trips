<?php

declare(strict_types=1);

namespace App\Domain\Trip\Exception;

final class TripIntersectionException extends TripException
{
    protected $message = 'The trip intersects with existing';
}
