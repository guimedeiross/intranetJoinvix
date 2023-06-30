<?php

namespace App\Controllers\AdminManager;

use App\Controllers\BaseController;

class UserManager extends BaseController
{
    public function index()
    {
        return view('adminManager/user', ['bodyClean' => true, 'moduleName' => 'Gerenciamento Usuários', 'routeToNameTitle' => 'UserManger']);
    }
}
