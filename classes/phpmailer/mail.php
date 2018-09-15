<?php
include('phpmailer.php');
class Mail extends PhpMailer
{
    // Set default variables for all new objects
    public $From     = 'urvashimeena25@gmail.com';
    public $FromName = ADMIN;
    public $Port = 587; 
    public $Host     = 'smtp.gmail.com';
    public $Mailer   = 'smtp';
    public $SMTPAuth = true;
    public $Username = 'urvashimeena25@gmail.com';
    public $Password = 'a1b2c3d$';
    public $SMTPSecure = 'tls';
    public $WordWrap = 75;

    public function subject($subject)
    {
        $this->Subject = $subject;
    }

    public function body($body)
    {
        $this->Body = $body;
    }

    public function send()
    {
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n", $this->AltBody);
        return parent::send();
    }
}
