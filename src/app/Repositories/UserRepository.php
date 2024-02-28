<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function addUser($name, $email, $password, $roleId)
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->roleId = $roleId;
        return $user->save();
    }
}
