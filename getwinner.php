<?php
    $sql_expired_lots = "SELECT MAX(cost) AS max_bet, bets.lot_id, lots.name as title, author, lots.id AS id, url, date_delection FROM lots JOIN bets ON lots.id = bets.lot_id WHERE date_delection < NOW() AND lots.winner IS NULL GROUP BY lots.id ORDER BY date_delection DESC;";
    $result_lots = mysqli_query($connection, $sql_expired_lots);
    if (!$result_lots) {
        exit;
    }
    $expired_lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

    require_once ("vendor/autoload.php");
    // Create the Transport
    $transport = (new Swift_SmtpTransport($config['smtp_server'], 465))
        ->setUsername($config['MailFromUsername'])
        ->setPassword($config['MailFromPassword']);


    $mailer = new Swift_Mailer($transport);

    foreach ($expired_lots as $info):
        $sql = "SELECT name, email, id from users WHERE id = " . intval($info['author']);
        $result_winner_info = mysqli_query($connection, $sql);
        if (!$result_winner_info) {
            die("Ошибка получения данных о победителе лота!");
        }
        $winner = mysqli_fetch_assoc($result_winner_info);

        $sql_winner = "UPDATE `lots` SET `winner` = " . intval($winner['id']) . " WHERE id = " . intval($info['id']);
        $result_winner = mysqli_query($connection, $sql_winner);
        if (!$result_winner) {
            die("Ошибка добавления победителя в БД!");
        }

            $message = (new Swift_Message('Ваша ставка выиграла'))
                ->setFrom([$config['MailTransport'] => $config['MailUsername']])
                ->setTo([$winner['email'], $winner['email'] => $winner['name']])
                ->setBody(include_template('email.php', ['winner' => $winner, 'href' => $config['href']]));
            // Send the message
        $result = $mailer->send($message);
    endforeach;
?>
