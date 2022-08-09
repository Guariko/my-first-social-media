<?php

$userImagePath = "images/user.png";

?>

<figure class="header__mobile__figure header__figure ">
    <img src="<?= $userImagePath ?>" alt="" class="header__mobile__image">
</figure>

<form action="" method="GET" class="search__here__mobile__container search__here__container">
    <input type="text" name="searching__for" placeholder="search here..." class="search__here">
    <button class="submit" name="searching"> <i class="fas fa-search"></i> </button>
</form>

<div class="redirect__message__mobile__container">
    <a href="#"> <i class="fas fa-envelope redirect__message__mobile"></i> </a>
</div>