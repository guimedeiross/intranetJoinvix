<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        $data = [
            'email' => $_ENV['ADMINEMAIL'],
            'password' => password_hash($_ENV['ADMINPASSWORD'], PASSWORD_DEFAULT),
            'reset_token' => null, 'reset_token_expiration' => null,
            'department_id' => 1
        ];
        $this->db->table('users')->insert($data);
    }
}
