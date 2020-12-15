<main>
<nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($categories as $cat): ?>
      <li class="nav__item">
        <a href="all-lots.html"><?= $cat['name']; ?></a>
      </li>
    <?php endforeach; ?>
    </ul>
  </nav>
  <?php $classname = !empty($errors) ? "form--invalid" : ""; ?>
  <form class="form form--add-lot container <?= $classname; ?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $classname = isset($errors['title']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname ?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование <sup>*</sup></label>
        <input id="lot-name" type="text" name="title" placeholder="Введите наименование лота" value="<?= htmlspecialchars(getPostVal('title')); ?>">
        <?php if(isset($errors['title'])){
         print('<span class="form__error">' . $errors['title'] . '</span>');
      }
      ?>
      </div>
      <div class="form__item">
        <label for="category_id">Категория <sup>*</sup></label>
        <select id="category_id" name="category_id">
          <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                      <?php if ($cat['id'] == getPostVal('category_id')): ?>selected<?php endif; ?>><?=$cat['name']; ?></option>
                 <?php endforeach; ?>
               </select>
        <span class="form__error">Выберите категорию</span>
      </div>
    </div>
    <?php if(isset($errors['category_id'])){
     print('<span class="form__error">' . $errors['category_id'] . '</span>');
   }
  ?>
    <?php $classname = isset($errors['description']) ? "form__item--invalid" : ""; ?>
    <div class="form__item form__item--wide <?= $classname ?>">
      <label for="description">Описание <sup>*</sup></label>
      <textarea id="description" name="description" placeholder="Напишите описание лота"> <?= htmlspecialchars(getPostVal('description')); ?></textarea>
      <?php if(isset($errors['description'])){
       print('<span class="form__error">' . $errors['description'] . '</span>');
    }
    ?>
    </div>
    <div class="form__item form__item--file form__item--invalid">
      <label>Изображение <sup>*</sup></label>
        <?php $classname = isset($errors['lot-img']) ? "form__item--invalid" : ""; ?>
      <div class="form__input-file <?= $classname ?>">
        <input class="visually-hidden" type="file" name="lot-img" id="lot-img" value="<?= getFilesVal('lot-img'); ?>">
        <label for="lot-img" value="<?=getPostVal('lot-img'); ?>">
          Добавить
        </label>
        <?php if(isset($errors['lot-img'])){
         print('<span class="form__error">' . $errors['lot-img'] . '</span>');
       }
      ?>
      </div>
    </div>
    <div class="form__container-three">
      <?php $classname = isset($errors['first_price']) ? "form__item--invalid" : ""; ?>
      <div class="form__item form__item--small <?= $classname ?>">
        <label for="first_price">Начальная цена <sup>*</sup></label>
        <input id="first_price" type="text" name="first_price" placeholder="0" value="<?= htmlspecialchars(getPostVal('first_price')); ?>">
        <?php if(isset($errors['first_price'])){
         print('<span class="form__error">' . $errors['first_price'] . '</span>');
       }
        ?>
      </div>
      <?php $classname = isset($errors['bet_step']) ? "form__item--invalid" : ""; ?>
      <div class="form__item form__item--small <?= $classname ?>">
        <label for="lot-step">Шаг ставки <sup>*</sup></label>
        <input id="bet_step" type="text" name="bet_step" placeholder="0" value="<?= htmlspecialchars(getPostVal('bet_step')); ?>">
        <?php if(isset($errors['bet_step'])){
         print('<span class="form__error">' . $errors['bet_step'] . '</span>');
       }
        ?>
      </div>
      <?php $classname = isset($errors['date_delection']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname ?>">

        <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
        <input class="form__input-date" id="date_delection" type="text" name="date_delection" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= htmlspecialchars(getPostVal('date_delection')); ?>">
        <?php if (isset($errors['date_delection'])){
           print('<span class="form__error">' . $errors['date_delection'] . '</span>');
        }
          ?>
      </div>
    </div>
    <button type="submit" class="button">Добавить лот</button>
  </form>
</main>
