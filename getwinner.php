<?php
    require_once '/path/to/vendor/autoload.php';
    $sql_expired_lots = "SELECT MAX(cost) AS max_bet, categories.name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step `id`, `name`, `email`, bets.user_id FROM lots JOIN users JOIN bets WHERE bets.cost = MAX(cost) AND bets.user_id = users.id JOIN categories ON categories.id = lots.category_id JOIN bets ON lots.id = bets.lot_id WHERE date_delection < NOW() GROUP BY lots.id ORDER BY date_delection DESC;";
    $result_lots = mysqli_query($connection, $sql_expired_lots);
    if (!$result_lots) {
        exit;
    }
    $expired_lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

    foreach ($expired_lots as $winner):

// Create the Transport
        $transport = (new Swift_SmtpTransport('keks@phpdemo.ru', 25))
            ->setUsername('keks@phpdemo.ru')
            ->setPassword('htmlacademy')
        ;

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['keks@phpdemo.ru' => $winner['name']])
            ->setTo([$winner['email'], $winner['email'] => $winner['name']])
            ->setBody(include_template('email.php', $winner));
// Send the message
        $result = $mailer->send($message);
    endforeach;
?>
