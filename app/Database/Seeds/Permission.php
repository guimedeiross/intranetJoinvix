<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Permission extends Seeder
{
    public function run()
    {
        $data = [
            'user_id' => 1,
            'module_id' => 1,
        ];
        $this->db->table('permissions')->insert($data);
    }
}
