<?php

declare(strict_types=1);

namespace Bitpanda\User\Domain;

use Bitpanda\User\Domain\Criteria\UserCriteria;

interface UserRepositoryInterface
{
    // I am lazy to create a "Collection" object to make sure the return are
    // objects of the actual User Class.

    // Also here, you might want to add the function "findActiveAustrianUsers".
    // That's an antipattern that will lead to thousands of unreusable functions and lines of code.
    public function search(UserCriteria $userCriteria): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function find(int $id): User;

    public function save(User $user): void;
}
