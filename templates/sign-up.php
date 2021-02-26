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
    <form class="form container form--invalid" action="sign-up.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?php if(isset($errors['email'])){
            print("form__item--invalid" );
        } ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= getPostVal('email');?>">
            <?php if(isset($errors['email'])){
                print('<span class="form__error">' . $errors['email'] . '</span>');
            }
            ?>
        </div>
        <div class="form__item <?php if(isset($errors['password'])){
            print("form__item--invalid" );
        } ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= getPostVal('password');?>">
            <?php if(isset($errors['password'])){
                print('<span class="form__error">' . $errors['password'] . '</span>');
            }
            ?>
        </div>
        <div class="form__item <?php if(isset($errors['name'])){
            print("form__item--invalid" );
        } ?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= getPostVal('name');?>">
            <?php if(isset($errors['name'])){
                print('<span class="form__error">' . $errors['name'] . '</span>');
            }
            ?>
        </div>
        <div class="form__item <?php if(isset($errors['message'])){
            print("form__item--invalid" );
        } ?>">
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= getPostVal('message');?></textarea>
            <?php if(isset($errors['message'])){
                print('<span class="form__error">' . $errors['message'] . '</span>');
            }
            ?>
        </div>
        <?php if(!empty($errors)){
            print('<span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>');
        }
        ?>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>
