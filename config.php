<?php
    require_once ("vendor/autoload.php");
    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 465))
        ->setUsername('c6bd6800aecad7')
        ->setPassword('4e7a293ef3b253');


    $mailer = new Swift_Mailer($transport);

    $config = [
        'href' => 'https://localhost',
    ];
?>
