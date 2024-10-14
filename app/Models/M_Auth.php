<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Auth extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'username';
    protected $allowedFields = ['username', 'password', 'role'];

    public function checkCredentials($username, $password)
    {
        $user = $this->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}