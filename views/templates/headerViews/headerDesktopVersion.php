<?php

session_start();

?>

<div class="header__logo__search__desktop__container">

    <figure class="header__logo__desktop__container">
        <a href="<?= $_SESSION["homePath"] ?>">
            <i class="fas fa-g"></i>
        </a>

    </figure>

    <form action="" method="GET" class="search__here__container">
        <input type="text" name="searching__for" placeholder="search here..." class="search__here">
        <button class="submit" name="searching"> <i class="fas fa-search"></i> </button>
    </form>

</div>

<nav class="header__nav__bar__container">
    <ul class="header__nav__bar">
        <li class="header__nav__bar__item__container">
            <i class="fa-solid fa-house-chimney"></i>
            <a href="#" class="header__nav__bar__item  ">home</a>
            <div class="header__nav__bar__decoration active"></div>
        </li>

        <li class="header__nav__bar__item__container">
            <i class="fa-solid fa-user-group"></i>
            <a href="#" class="header__nav__bar__item">friends</a>
            <div class="header__nav__bar__decoration"></div>
        </li>

        <li class="header__nav__bar__item__container">
            <i class="fa-solid fa-envelope"></i>
            <a href="<?= $_SESSION["messagingPath"] ?>" class="header__nav__bar__item">messaging</a>
            <div class="header__nav__bar__decoration"></div>
        </li>

        <li class="header__nav__bar__item__container">
            <i class="fa-solid fa-bell"></i>
            <a href="#" class="header__nav__bar__item">notifications</a>
            <div class="header__nav__bar__decoration"></div>
        </li>

        <li class="header__nav__bar__item__container header__user__logo__desktop ">
            <figure>
                <img src="<?= $_SESSION["userImagePath"] ?>" alt="" class="user__image__desktop">
            </figure>
        </li>
    </ul>
</nav>