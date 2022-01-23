<?php

declare(strict_types=1);

namespace Bitpanda\User\Domain\Criteria;

class UserCriteria
{
    private UserActiveFilter $userActiveFilter;
    public function __construct(
        private ?CountryFilter $countryFilter = null
    )
    {
        // Domain logic: I am assuming we are always searching active users when applying criteria.
        // If that would be different that decision might have to be placed on the command handler.
        // I am just assuming it is a business decision, therefore this logic should be placed in the domain.
        $this->userActiveFilter = new UserActiveFilter(true);
    }

    public function getFilters(): array
    {
        $filters = [
            $this->userActiveFilter,
        ];

        if ($this->countryFilter) {
            $filters[] =  $this->countryFilter;
        }

        return $filters;
    }

    // You can add here order and limits for pagination for example.

}
