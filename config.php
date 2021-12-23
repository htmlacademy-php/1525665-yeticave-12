<?php
    $config = [
        'href' => 'https://localhost',
        'db_password' => '',
        'db_username' => 'root',
        'db_title' => 'YetiCave',
        'db_host' => 'localhost',
        'smtp_server' => 'smtp.mailtrap.io',
        'MailFromUsername' => 'c6bd6800aecad7',
        'MailFromPassword' => '4e7a293ef3b253',
        'MailTransport' => 'delemoses567@gmail.com',
        'MailUsername' => 'Илья П'
    ];

    require_once ("vendor/autoload.php");
    // Create the Transport
    $transport = (new Swift_SmtpTransport($config['smtp_server'], 465))
        ->setUsername($config['MailFromUsername'])
        ->setPassword($config['MailFromPassword']);


    $mailer = new Swift_Mailer($transport);
?>
