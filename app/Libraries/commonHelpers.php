<?php

namespace App\Libraries;

use App\User;

class CommonHelpers
{
    public static function UsersList()
    {
        return User::get();
    }   
}
