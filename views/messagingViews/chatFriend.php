<?php

$friendImagePath = null;
$friendName = null;

if (isset($_GET["getChatFriendInformations"])) {
    $friendImagePath = strip_tags($_GET["friendImagePath"]);
    $friendName = strip_tags($_GET["friendName"]);
}

?>

<i class="fa-solid fa-angle-left"></i>

<picture>
    <img src="<?= $friendImagePath ?>" alt="" class="chat__friend__image">
</picture>

<h2 class="friend__chat__name"> <?= $friendName ?> </h2>