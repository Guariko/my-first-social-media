<?php

session_start();

if (!isset($_SESSION["userLogged"])) {
    header("location: loginRegister/login.php");
    die();
}


$dataBaseConnectionPath = "../configs/database/databaseConnection.php";
require_once("../configs/controllers/databaseClassesController.php");


$styles = "../css/styles.css";
$normalizeCss = "../css/normalize.css";

include("templates/headFoot/head.php");

$_SESSION["homePath"] = "../index.php";
$_SESSION["messagingPath"] = "messaging.php";
$_SESSION["userImagePath"] = "../images/" . $_SESSION["userData"]["user_image"];
$_SESSION["userProfilePath"] = "userProfile.php";

$logOutPath = "../configs/controllers/logOutController.php";

include("templates/header.php");

?>

<main class="main user__profile__main ">

    <section class="user__profile__container">

        <div class="start__post__container">

            <div class="port__container">

                <form action="" method="POST" class="post__form">

                    <textarea name="" id="" cols="30" rows="10" class="user__description" placeholder="Your message"></textarea>

                    <button type="submit" class="post__button button">done</button>
                    <button type="button" class="choose__image__button button ">choose an image</button>
                </form>

                <picture class="image__selected__container">
                    <img src="" alt="" class="image__selected">
                </picture>

            </div>

        </div>

        <div class="user__informations__container">

            <div class="user__profile__buttons__container">

                <mark class="post__button button ">start a post</mark>
                <form action="" class="select__user__image__form" enctype="multipart/form-data" method="POST">
                    <input type="file" accept="image/*" class="user__image__input" id="user__image__input" name="user__image__data">
                    <label class="choose__image__button button" for="user__image__input">select an image</label>

                </form>
                <mark class="button"> change password </mark>

            </div>

            <article class="user__informations">

                <picture class="user__image__container">
                    <img src="<?= $_SESSION["userImagePath"] ?>" alt="" class="current__user__image">
                </picture>

                <div class="user__name__container">

                    <h1 class="user__name"> <?= $_SESSION["userData"]["name"] ?> </h1>
                    <a href="<?= $logOutPath ?>" class="button log__out ">log out</a>

                </div>

            </article>

        </div>

    </section>

</main>

<?php

$scripts = "../js/index.js";
$subScripts = "../js/user.js";

include("templates/headFoot/foot.php");
