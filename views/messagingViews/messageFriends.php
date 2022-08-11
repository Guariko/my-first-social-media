<?php

if (isset($_GET["sortFriends"])) {

    session_start();

    $friendNameMinLength = 1;

    $dataBaseConnectionPath = "../../configs/database/databaseConnection.php";
    require_once("../../configs/controllers/databaseClassesController.php");

    $friendName = strip_tags($_GET["friendName"]);

    if (strlen($friendName) < $friendNameMinLength) {
        $usersData = DataBase::getAllUsersData($_SESSION["userData"]["id"]);
    } else {

        $usersData = DataBase::sortFriends($_GET["friendName"], $_SESSION["userData"]["id"]);
    }
}

foreach ($usersData as $userData) : ?>

    <div class="messaging__friend__container" data-friendid="<?= $userData["id"] ?>">

        <figure class="friend__image__container">
            <img src="<?= "../images/" . $userData["user_image"] ?>" alt="" class="friend__image">
        </figure>

        <h2 class="friend__name"> <?= $userData["name"] ?> </h2>

    </div>

<?php endforeach;
