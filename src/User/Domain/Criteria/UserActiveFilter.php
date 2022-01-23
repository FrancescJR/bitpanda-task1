<?php

declare(strict_types=1);

namespace Bitpanda\User\Domain\Criteria;

final class UserActiveFilter
{
    public function __construct(private bool $value)
    {

    }

    public function value(): bool
    {
        return $this->value;
    }

}
