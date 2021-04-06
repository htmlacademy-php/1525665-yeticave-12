<div class="container">
    <section class="lots">
        <?php if(empty($lots)): ?>
        <h2>По вашему запросу ничего не найдено</h2>
        <?php else: ?>
        <h2>Результаты поиска по запросу «<span><?= $search ?></span>»</h2>
        <?php endif; ?>
        <ul class="lots__list">
            <?php
            foreach ($lots as $lot):
                $result_time = deletion_of_lot($lot['date_delection']);
                ?>
                <li class="lots__item lot">
                    <div class="image">
                        <img src="<?=$lot['url']; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <?php
                        $lot_url = 'lot.php?' . http_build_query(['id' => $lot['id'] ]);
                        ?>
                        <span class="lot__category"><?=$lot['category_name'];?></span>
                        <h3 class="lot__title">  <a class="text-link" href="<?= $lot_url; ?>"><?= htmlspecialchars($lot['name']);?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"> <?= htmlspecialchars(format_sum($lot['first_price'])); ?></span>
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
</div>
