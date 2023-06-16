<?php

namespace App\Controllers;

use App\Libraries\Mail;
use CodeIgniter\Database\RawSql;
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

    public function destroy()
    {
        session()->destroy();

        return redirect()->route('login');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $validate = $this->validate([
            'EnderecoEmail' => 'required|valid_email',
            'password' => 'required|min_length[8]',
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
    ]);
        if (!$validate) {
            return redirect()->route('loginStore')->with('errorsLogin', $this->validator->getErrors());
        }
        $db = Database::connect();
        $builder = $db->table('users');

        $user = $builder->where('email', $data['EnderecoEmail'])->get()->getFirstRow();

        if (!$user) {
            return redirect()->back()->with('user_not_found', 'Usuário ou senha inválidos.');
        }

        if (!password_verify($data['password'], $user->password)) {
            return redirect()->back()->with('user_not_found', 'Usuário ou senha inválidos.');
        }
        unset($user->password);
        unset($user->reset_token);
        unset($user->reset_token_expiration);
        session()->set('user', $user);

        return redirect()->route('home');
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
        $email = $data['RecoverEnderecoEmail'];

        $db = Database::connect();
        $builder = $db->table('users');

        $query = $builder->select('id,email')->where('email', $email);
        $userInfo = $query->get();
        $emailsDb = $userInfo->getNumRows();

        if ($emailsDb === 0) {
            return redirect()->route('recoverPassword')->with('errorDuplicateEmailRecover', 'Este email não consta no sistema, faça o cadastro');
        }

        // recuperar a senha
        $date = new \DateTime();
        $date->modify('+10 minutes');

        $token = md5(uniqid());

        $builder->set([
            'reset_token_expiration' => $date->format('Y-m-d H:i:s'),
            'reset_token' => $token,
        ]);

        $builder->where('id', $userInfo->getFirstRow()->id);
        $update = $builder->update();
        if (!$update) {
            return redirect()->route('recoverPassword')->with('errors', 'Problema ao recuperar senha, tente novamente daqui a alguns minutos');
        }

        $mail = new Mail();
        $mail->setFrom(['email' => 'no-reply@joinvix.com.br', 'name' => 'Recuperar Senha']);
        $mail->setTo($email);
        $mail->setSubject('Recuperação de Senha');
        $mail->setTemplate('emails/recoverPassword', ['token' => $token]);
        ($mail->send()) ?
        session()->setFlashdata('forgot_sent', 'Enviamos um link para recuperação de senha para seu email.') :
        session()->setFlashdata('forgot_not_sent', 'Ocorreu um erro ao enviar o email, tente novamente em alguns segundos.');

        return redirect()->route('recoverPassword');
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

        if ($emailsDb > 0) {
            return redirect()->route('signUp')->with('errorDuplicateEmail', 'Este email já existe no sistema.');
        }

        $inserted = $builder->insert($dataInsert);

        if (!$inserted) {
            return redirect()->route('signUp')->with('errorInsertEmail', 'Oops, problema no cadastro, entrar em contato com adm do sistema');
        }

        return redirect()->route('login')->with('insertSuccess', 'Cadastro efetuado com sucesso.');
    }

    public function resetPasswordIndex($token)
    {
        $this->data['token'] = $token;
        $db = Database::connect();
        $builder = $db->table('users');

        $tokenFound = $builder->where('reset_token', $token)->get()->getFirstRow();

        if (!$tokenFound) {
            session()->setFlashdata('token_not_found', 'Token não existe ou não é válido.');

            return redirect()->route('viewRecoverPassword');
        }

        $expiration = new \DateTime($tokenFound->reset_token_expiration);
        $now = new \DateTime();

        if ($now > $expiration) {
            session()->setFlashdata('token_not_found', 'Token não existe ou não é válido.');

            return redirect()->route('viewRecoverPassword');
        }

        return view('resetPassword', $this->data);
    }

    public function resetPasswordStore($token)
    {
        $data = $this->request->getPost()['password'];
        $validate = $this->validate([
            'password' => 'required|min_length[8]',
            ],
            [
                'password' => [
                    'required' => 'O campo senha é obrigatório.',
                    'min_length' => 'O campo senha deve conter pelo menos 8 caracteres',
                ],
            ]);
        if (!$validate) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $db = Database::connect();
        $builder = $db->table('users');

        $tokenFound = $builder->where('reset_token', $token)->get()->getFirstRow();

        if (!$tokenFound) {
            session()->setFlashdata('token_not_found', 'Token não existe ou não é válido.');

            return redirect()->route('viewRecoverPassword');
        }

        $expiration = new \DateTime($tokenFound->reset_token_expiration);
        $now = new \DateTime();

        if ($now > $expiration) {
            session()->setFlashdata('token_not_found', 'Token não existe ou não é válido.');

            return redirect()->route('viewRecoverPassword');
        }
        $fieldsToUpdate = [
            'password' => password_hash($data, PASSWORD_DEFAULT),
            'updated_at' => new RawSql('CURRENT_TIMESTAMP'),
        ];
        $update = $builder->set($fieldsToUpdate)->where('id', $tokenFound->id)->update();

        if (!$update) {
            return redirect()->route('login')->with('problem_update_password', 'Woops, problema ao atualizar senha, tente novamente em alguns minutos.');
        }

        return redirect()->route('login')->with('update_password', 'Senha atualizada.');
    }
}
