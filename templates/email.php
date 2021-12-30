<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= htmlspecialchars($winner['name']); ?></p>
<p>Ваша ставка для лота <a
        href="<?= $href ?>/lot.php?id=<?= $winner['id'] ?>"><?= htmlspecialchars($winner['title']) ?></a> победила.</p>
<p>Перейдите по ссылке <a href="<?= $href ?>/my-bets.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>
<small>Интернет-Аукцион "YetiCave"</small>
