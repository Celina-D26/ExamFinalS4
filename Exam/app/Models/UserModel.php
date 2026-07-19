<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public function authenticate($username, $password)
    {
        $user = $this->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }


}