<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Module extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'ALL',
        ];
        $this->db->table('modules')->insert($data);
    }
}
