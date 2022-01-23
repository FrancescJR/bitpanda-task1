<?php

declare(strict_types=1);

namespace Bitpanda\User\Application;

final class EditUserCommand
{
    public function __construct(
        public readonly ?int $userId,
        public readonly ?string $phoneNumber
    )
    {

    }

}
