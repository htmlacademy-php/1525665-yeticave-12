<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $cat): ?>
                <li class="nav__item">
                    <a href="/?category=<?= $cat['id']; ?>"><?= $cat['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
        <?php foreach ($bets as $bet): ?>
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="../<?= $bet['lot_image'] ?>" width="54" height="40" alt="<?= $bet['lot_name'] ?>">
            </div>
            <?php $lot_url = 'lot.php?' . http_build_query(['id' => $bet['id'] ]); ?>
            <h3 class="rates__title"><a href="<?= $lot_url ?>"><?= $bet['lot_name']; ?></a></h3>
          </td>
          <td class="rates__category">
              <?= $bet['category']; ?>
          </td>
          <td class="rates__timer">
            <div class="timer <?php
            $result_time = deletion_of_lot($bet['date_delection']);
            if (is_lot_expire_soon($bet['date_delection'])) {
                echo ' timer--finishing';
            }
            ?>"><?= $rest_time = implode(":", $result_time); ?></div>
          </td>
          <td class="rates__price">
                <?= $bet['cost']; ?>
          </td>
          <?php $remaining_minutes = remaining_minutes($bet['time']); ?>
          <td class="rates__time">
<?= $remaining_minutes; ?>
</td>
        </tr>
          <?php endforeach; ?>
      </table>
    </section>
  </main>
