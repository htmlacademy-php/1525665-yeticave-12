<main>
    <section class="lot-item container">
      <h2><?= htmlspecialchars($lot['name']); ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?= $lot['url']; ?>" width="730" height="548" alt="<?= htmlspecialchars($lot['name']); ?>">
          </div>
          <p class="lot-item__category">Категория: <span><?= $lot['category_name']; ?></span></p>
          <p class="lot-item__description"><?= htmlspecialchars($lot['description']); ?></p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state">
            <div class="lot-item__timer timer <?php
                $result_time = deletion_of_lot($lot['date_delection']);
                if (is_lot_expire_soon($lot['date_delection'])) {
                    echo ' timer--finishing';
                }
                ?>">
              <?=  $rest_time = implode(":", $result_time); ?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost">
                <p><?= $current_cost; ?></p>
               </span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?= htmlspecialchars($minimal_bet); ?> р</span>
              </div>
            </div>
            <?php if($is_auth === 1 && $hide !== 1): ?>
            <form class="lot-item__form" action="" method="post" autocomplete="off">
              <?php $classname = isset($errors['cost']) ? "form__item--invalid" : ""; ?>
              <p class="lot-item__form-item form__item <?= $classname; ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= htmlspecialchars($minimal_bet); ?>">
                <?php
                    if(isset($errors["cost"])) {
                        print('<span class="form__error">' . $errors["cost"] . '</span>');
                    }
                    ?>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
            <?php endif; ?>
          </div>
            <div class="history">
                        <?php
                            $k = count($bets_history);
                        ?>
                        <h3>История ставок (<span><?= $k; ?></span>)</h3>
                        <table class="history__list">
                            <?php
                                foreach ($bets_history as $bet):
                                $remaining_minutes = remaining_minutes($bet['time']);
                                ?>
                            <tr class="history__item">
                                <td class="history__name"><?= htmlspecialchars($bet['name']); ?></td>
                                <td class="history__price"><?= $bet['cost']; ?> р</td>
                                <td class="history__time"><?= $remaining_minutes; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
            </div>
        </div>
      </div>
    </section>
</main>
