<?php
    $sql_expired_lots = "SELECT MAX(cost) AS max_bet, bets.lot_id, lots.name as title, lots.id AS id, url, date_delection FROM lots JOIN bets ON lots.id = bets.lot_id WHERE date_delection < NOW() GROUP BY lots.id ORDER BY date_delection DESC;";
    $result_lots = mysqli_query($connection, $sql_expired_lots);
    if (!$result_lots) {
        exit;
    }
    $expired_lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    var_dump($expired_lots);

    foreach ($expired_lots as $e):
        $sql_winners = "ЫУДУС";
        $result_winners = mysqli_query($connection, $sql_winners);
        if (!$result_winners) {
            exit;
        }
    $winners = mysqli_fetch_all($result_winners, MYSQLI_ASSOC);
    endforeach;
    var_dump($expired_lots);
//    require_once 'vendor/autoload.php';
//    foreach ($expired_lots as $winner):
//    SELECT MAX(cost) AS max_bet, categories.name, lots.name as title, lots.id AS id, first_price, url, date_delection, bet_step `id`, `name`, `email`, bets.user_id FROM lots JOIN users JOIN bets WHERE bets.cost = MAX(cost) AND bets.user_id = users.id JOIN categories ON categories.id = lots.category_id JOIN bets ON lots.id = bets.lot_id WHERE date_delection < NOW() GROUP BY lots.id ORDER BY date_delection DESC;
//    // Create the Transport
//        $transport = (new Swift_SmtpTransport('keks@phpdemo.ru', 25))
//            ->setUsername('keks@phpdemo.ru')
//            ->setPassword('htmlacademy')
//
//
//        $mailer = new Swift_Mailer($transport);
//
//        $message = (new Swift_Message('Wonderful Subject'))
//            ->setFrom(['keks@phpdemo.ru' => 'htmlacademy'])
//            ->setTo([$winner['email'], $winner['email'] => $winner['name']])
//            ->setBody(include_template('email.php', $winner));
//    // Send the message
//        $result = $mailer->send($message);
//    endforeach;
?>
