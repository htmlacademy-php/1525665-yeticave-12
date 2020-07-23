<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php
                foreach($categories as $category):
               ?>
            <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="pages/all-lots.html"><?=$category; ?></a>
              </li>
              <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($products as $product): ?>
            <li class="lots__item lot">
              <div class="image">
                    <img src="<?=$product['image']; ?>" width="350" height="260" alt="">
              </div>
              <div class="lot__info">
                 <span class="lot__category"><?=$product['category'];?></span>
                  <h3 class="lot__title">  <a class="text-link" href="pages/lot.html"><?= htmlspecialchars($product['title']);?></a></h3>
                  <div class="lot__state">
                      <div class="lot__rate">
                          <span class="lot__amount">Стартовая цена</span>
                         <span class="lot__cost"> <?= htmlspecialchars(format_sum($product['cost'])); ?></span>
                      </div>
                      <div class="lot__timer timer <?php
                      $result = timer_2($product['date']);
                      if ($result < 1){
                     echo ' timer--finishing';
                   };
                       ?>" 
                       >
                          <?=  $rest_time = implode(":", timer_2($product['date']));
                          ?>
                      </div>
                    </div>
                </div>
            </li>
               <?php endforeach; ?>
        </ul>
    </section>
</main>
