<?php

declare(strict_types=1);

namespace Bitpanda\User\Domain\Criteria;

final class CountryFilter
{
    public function __construct(public readonly int $countryFilter)
    {

    }

}
