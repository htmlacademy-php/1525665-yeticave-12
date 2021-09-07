<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php
                foreach($categories as $category):
               ?>
            <li class="promo__item promo__item--<?=$category['img']; ?>">
                    <a class="promo__link" href="pages/all-lots.html"><?=$category['name']; ?></a>
              </li>
              <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php
              foreach ($products as $product):
              $result_time = deletion_of_lot($product['date_delection']);
            ?>
            <li class="lots__item lot">
              <div class="image">
                    <img src="<?=$product['url']; ?>" width="350" height="260" alt="">
              </div>
              <div class="lot__info">
                <?php
                $lot_url = 'lot.php?' . http_build_query(['id' => $product['id'] ]);
                ?>
                 <span class="lot__category"><?=$product['category_name'];?></span>
                  <h3 class="lot__title">  <a class="text-link" href="<?= $lot_url; ?>"><?= htmlspecialchars($product['name']);?></a></h3>
                  <div class="lot__state">
                      <div class="lot__rate">
                          <span class="lot__amount">Стартовая цена</span>
                         <span class="lot__cost"> <?= htmlspecialchars(format_sum($product['first_price'])); ?></span>
                      </div>
                      <div class="lot__timer timer
                          <?php
                               if ($result_time[0] < 1){
                                  echo ' timer--finishing';
                              };
                          ?>">
                          <?=  $rest_time = implode(":", $result_time);?>
                      </div>
                    </div>
                </div>
            </li>
               <?php endforeach; ?>
        </ul>
    </section>
    <?php if ($pages_count > 1): ?>
        <ul class="pagination-list">
            <?php if ($cur_page !== 1): ?>
                <li class="pagination-item pagination-item-prev"><a href="/?page=<?= $cur_page - 1;?>">Назад</a></li>
            <?php endif; ?>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page === $cur_page): ?>pagination__item-active<?php endif; ?>"><a href="/?page=<?=$page;?>"><?=$page;?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><a href="/?page=<?= $cur_page + 1;?>">Вперед</a></li>
        </ul>
        </div>
    <?php endif; ?>
</main>
