<?php

namespace App\Controllers;

use Config\Database;

class Auth extends BaseController
{
    private $data = [
        'title' => 'Intranet Joinvix',
        'bodyClean' => false,
    ];

    public function index()
    {
        return view('login', $this->data);
    }

    public function signupIndex()
    {
        return view('signup', $this->data);
    }

    public function recoverPasswordIndex()
    {
        return view('recoverPassword', $this->data);
    }

    public function recoverPasswordStore()
    {
        $validate = $this->validate([
            'RecoverEnderecoEmail' => 'required|valid_email',
        ],
            [
                'RecoverEnderecoEmail' => [
                    'required' => 'O campo email é obrigatório.',
                    'valid_email' => 'O campo email deve conter um endereço de e-mail válido.',
                ],
            ]);

        if (!$validate) {
            return redirect()->route('recoverPassword')->with('errors', $this->validator->getErrors());
        }
        $data = $this->request->getPost();

        $db = Database::connect();
        $builder = $db->table('users');

        $query = $builder->select('email')->where('email', $data['RecoverEnderecoEmail']);
        $emailsDb = $query->get()->getNumRows();

        if($emailsDb === 0) return redirect()->route('recoverPassword')->with('errorDuplicateEmailRecover', 'Este email não consta no sistema, faça o cadastro');

        // recuperar a senha
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
                    'valid_email' => 'O campo email deve conter um endereço de e-mail válido.',
                ],
                'password' => [
                    'required' => 'O campo senha é obrigatório.',
                    'min_length' => 'O campo senha deve conter pelo menos 8 caracteres',
                ],
                'confirmPassword' => [
                    'required' => 'O campo confirmação de senha é obrigatório.',
                    'matches' => 'As senhas não conferem',
                ],
    ]);
        if (!$validate) {
            return redirect()->route('signUp')->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        $db = Database::connect();
        $builder = $db->table('users');

        $dataInsert = ['email' => $data['EnderecoEmail'], 'password' => password_hash($data['password'], PASSWORD_DEFAULT)];
        
        $query = $builder->select('email')->where('email', $dataInsert['email']);
        $emailsDb = $query->get()->getNumRows();

        if($emailsDb > 0) return redirect()->route('signUp')->with('errorDuplicateEmail', 'Este email já existe no sistema.');

        $inserted = $builder->insert($dataInsert);

        if (!$inserted) {
            return redirect()->route('signUp')->with('errorInsertEmail', 'Oops, problema no cadastro, entrar em contato com adm do sistema');
        }

        return redirect()->route('login')->with('insertSuccess', 'Cadastro efetuado com sucesso.');
    }
}
