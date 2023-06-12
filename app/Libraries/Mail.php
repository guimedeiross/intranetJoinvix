<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;
use Config\Services;

class Mail
{
    private Email $email;
    private ?string $template = null;

    public function __construct()
    {
        $this->initialize();
    }

    private function initialize()
    {
        $this->email = Services::email();
        $this->email->initialize([
            'protocol' => 'smtp',
            'SMTPHost' => $_ENV['SMTPHOST'],
            'SMTPUser' => $_ENV['SMTPUSER'],
            'SMTPPass' => $_ENV['SMTPPASS'],
            'SMTPPort' => $_ENV['SMTPPORT'],
            'wordWrap' => true,
            'charset' => 'utf-8',
        ]);
    }

    public function setFrom(array $from)
    {
        $this->email->setFrom($from['email'], $from['name']);
    }

    public function setTo(string $to)
    {
        $this->email->setTo($to);
    }

    public function setSubject(string $subject)
    {
        $this->email->setSubject($subject);
    }

    public function setTemplate(string $template, array $data)
    {
        $this->template = view($template, $data);
        $this->email->setMailType('html');
        $this->email->setMessage($this->template);
    }

    public function setMessage(string $message)
    {
        if ($this->template) {
            throw new \Exception('You already selected a template to send email');
        }
        $this->email->setMailType('text');
        $this->email->setMessage($message);
    }

    public function send()
    {
        return $this->email->send();
    }
}
