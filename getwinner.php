<?php
    $sql_expired_lots = "SELECT MAX(cost) AS max_bet, bets.lot_id, lots.name as title, author, lots.id AS id, url, date_delection FROM lots JOIN bets ON lots.id = bets.lot_id WHERE date_delection < NOW() GROUP BY lots.id ORDER BY date_delection DESC;";
    $result_lots = mysqli_query($connection, $sql_expired_lots);
    if (!$result_lots) {
        exit;
    }
    $expired_lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    var_dump($expired_lots);

    require_once 'vendor/autoload.php';
    foreach ($expired_lots as $info):
        $sql = "SELECT name, email, id from users WHERE id = " . $info['author'];
        $result_winner_info = mysqli_query($connection, $sql);
        if (!$result_winner_info) {
            exit;
        }
        $winner = mysqli_fetch_assoc($result_winner_info);

            // Create the Transport
            $transport = (new Swift_SmtpTransport('keks@phpdemo.ru', 25))
                ->setUsername('keks@phpdemo.ru')
                ->setPassword('htmlacademy');


            $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message('Wonderful Subject'))
                ->setFrom(['keks@phpdemo.ru' => 'htmlacademy'])
                ->setTo([$winner['email'], $winner['email'] => $winner['name']])
                ->setBody(include_template('email.php', $winner));
            // Send the message
        $result = $mailer->send($message);
    endforeach;
?>
