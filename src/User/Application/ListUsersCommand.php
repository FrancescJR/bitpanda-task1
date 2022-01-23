<?php

declare(strict_types=1);

namespace Bitpanda\User\Application;

final class ListUsersCommand
{
    public function __construct(public readonly ?string $countryFilter)
    {

    }

}
