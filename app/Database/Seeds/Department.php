<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Department extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'ADMIN',
        ];
        $this->db->table('departments')->insert($data);
    }
}
