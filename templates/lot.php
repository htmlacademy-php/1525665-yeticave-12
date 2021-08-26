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
          <?php if($is_auth === 1): ?>
          <div class="lot-item__state">
            <div class="lot-item__timer timer <?php
              if ($result_time[0] < 1){
                echo ' timer--finishing';
              }; ?>">
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
                Мин. ставка <span><?= htmlspecialchars($lot['min_bet']);  ?></span>
              </div>
            </div>
             <?php endif; ?>
            <form class="lot-item__form" action="" method="post" autocomplete="off">
              <?php $classname = isset($errors['cost']) ? "form__item--invalid" : ""; ?>
              <p class="lot-item__form-item form__item <?= $classname; ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="12 000">
                <?php
                    if(isset($errors["cost"])) {
                        print('<span class="form__error">Ставка должна быть целым положительным числом</span>');
                    }
                    ?>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
            <div class="history">
                <table class="history__list">
                    <tr class="history__item">
                        <h3>История ставок (<span>10</span>)</h3>
                        <table class="history__list">
                            <?php foreach ($bets_history as $bet):
                                var_dump($bets_history);?>
                            <tr class="history__item">
                                <td class="history__name"><?= $bet['name']; ?></td>
                                <td class="history__price"><?= $bet['cost']; ?></td>
                                <td class="history__time"><?= $bet['timestamp']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </tr>

                </table>
            </div>
        </div>
      </div>
    </section>
</main>
