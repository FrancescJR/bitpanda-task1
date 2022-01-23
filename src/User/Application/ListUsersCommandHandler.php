<?php

declare(strict_types=1);

namespace Bitpanda\User\Application;

use Bitpanda\User\Domain\Criteria\CountryFilter;
use Bitpanda\User\Domain\Criteria\UserCriteria;
use Bitpanda\User\Domain\User;
use Bitpanda\User\Domain\UserRepositoryInterface;

final class ListUsersCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(ListUsersCommand $listUsersCommand): array
    {
        $userCountryFilter = null;
        // Proper way should be to get an actual country from the repo with that code.
        // and passing the id of the country on that filter
        // doing it like this to go faster.
        if ($listUsersCommand->countryFilter === 'AUS') {
            $userCountryFilter = new CountryFilter(1);
        }

        $userList = $this->userRepository->search(new UserCriteria($userCountryFilter));

        $usersResponse = [];

        foreach ($userList as $user) {
            /**@var $user User */
            $usersResponse[] = UserResponse::fromUser($user)->toArray();
        }

        return $usersResponse;
    }

}
