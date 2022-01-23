<?php

declare(strict_types=1);

namespace Bitpanda\User\Infrastructure\Persistence\Eloquent;

use Bitpanda\User\Domain\Criteria\CountryFilter;
use Bitpanda\User\Domain\Criteria\UserActiveFilter;
use Bitpanda\User\Domain\Criteria\UserCriteria;
use Bitpanda\User\Domain\User;
use Bitpanda\User\Domain\UserNotFoundException;
use Bitpanda\User\Domain\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private UserModel $userModel,
    ) {
    }

    public function search(UserCriteria $userCriteria): array
    {
        $queryBuilder = $this->userModel;

        foreach ($userCriteria->getFilters() as $filter) {
            switch (get_class($filter)) {
                case UserActiveFilter::class:
                    $queryBuilder = $queryBuilder->where('active', 1);
                    break;
                case CountryFilter::class:
                    $queryBuilder = $queryBuilder->whereHas('userDetails', function (Builder $query) use ($filter) {
                        $query->where('citizenship_country_id', $filter->countryFilter);
                    }
                    );
                    break;
            }
        }

        $eloquentUsers = $queryBuilder->get();

        $users = [];
        foreach ($eloquentUsers as $eloquentUser) {
            $users[] = $eloquentUser->toDomain();
        }


        return $users;
    }

    public function find(int $id): User
    {
        $eloquentUser = $this->userModel->find($id);
        /**@var $eloquentUser UserModel */
        if (null === $eloquentUser) {
            throw new UserNotFoundException(sprintf("User with id %i not found", $id));
        }

        return $eloquentUser->toDomain();
    }

    /**
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function save(User $user): void
    {
        // not really happy about this. Well, trying to be independent of active record implementation...
        // That's why active record ORM are not recommended. Unit of work can give better abstractions.
        $eloquentUser = $this->userModel->find($user->id());

        DB::beginTransaction();
        try {
            $eloquentUser->fromDomain($user);
            $eloquentUser->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('TODO eloquent exception:' . $e->getMessage());
        }
    }
}
