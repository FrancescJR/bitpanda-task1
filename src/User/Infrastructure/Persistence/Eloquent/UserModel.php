<?php

declare(strict_types=1);

namespace Bitpanda\User\Infrastructure\Persistence\Eloquent;

use Bitpanda\User\Domain\User;
use Bitpanda\User\Domain\UserDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'users';

    public function userDetails()
    {
        return $this->hasOne(UserDetailsModel::class, 'user_id');
    }

    public function toDomain(): User
    {
        $userDetails = $this->userDetails()?->first();

        return new User(
            $this->id,
            (bool) $this->active,
            $this->email,
            // since it is one to one, it is ok to put that here, but if it were a list of entities
            // better to put that on the userdetails model.
            $userDetails ? new UserDetails(
                $userDetails->first_name,
                $userDetails->last_name,
                $userDetails->citizenship_country_id,
                $userDetails->phone_number
            ):null
        );
    }

    public function fromDomain(User $user): void
    {
        $this->id = $user->id();
        $this->email = "newemail@sdf.com";
        $this->active = $user->isActive();

        if ($user->userDetails()) {
            $userDetailsModel =  $this->userDetails()->first();
            $userDetailsModel->first_name = $user->userDetails()->firstName();
            $userDetailsModel->last_name = $user->userDetails()->lastName();
            $userDetailsModel->citizenship_country_id = $user->userDetails()->countryId();
            $userDetailsModel->phone_number = $user->userDetails()->phoneNumber();
            $userDetailsModel->save();
        }
    }


}
