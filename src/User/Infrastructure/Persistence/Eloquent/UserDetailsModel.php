<?php

declare(strict_types=1);

namespace Bitpanda\User\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class UserDetailsModel extends Model
{
    public $timestamps = false;

    protected $table = 'user_details';

}
