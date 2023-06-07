<?php

namespace App\Controllers;

use App\Models\User;

class Auth extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Intranet Joinvix',
        ];

        return view('login', $data);
    }

    public function signupIndex()
    {
        return view('signup');
    }

    public function signupStore()
    {
        $validate = $this->validate([
            'EnderecoEmail' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            'confirmPassword' => 'required|matches[password]',
        ],
            [
                'EnderecoEmail' => [
                    'required' => 'O campo email é obrigatório.',
                    'valid_email' => 'O campo email deve conter um endereço de e-mail válido.'
                ],
                'password' => [
                    'required' => 'O campo senha é obrigatório.',
                    'min_length' => 'O campo senha deve conter pelo menos 8 caracteres'
                ],
                'confirmPassword' => [
                    'required' => 'O campo confirmação de senha é obrigatório.',
                    'matches' => 'As senhas não conferem'
                ],
    ]);
        if (!$validate) {
            return redirect()->route('signUp')->with('errors', $this->validator->getErrors());
        }
        
        
    }
}
