<?php

session_start();

if (!isset($_SESSION["userLogged"])) {
    header("location: loginRegister/login.php");
    die();
}

$dataBaseConnectionPath = "../configs/database/databaseConnection.php";

require_once("../configs/controllers/databaseClassesController.php");

require_once("../configs/controllers/messagingController.php");

$normalizeCss = "../css/normalize.css";
$styles = "../css/styles.css";

include("templates/headFoot/head.php");

/* TODO: Header starts */

$_SESSION["homePath"] = "../index.php";
$_SESSION["messagingPath"] = "messaging.php";
$_SESSION["userImagePath"] = "../images/user.png";

include("templates/header.php");

/* FIXME: Header ends */

?>

<main class="messaging__main main">

    <section class="search__friend__section">
        <form action="" class="search__friend__container">
            <input type="text" name="searching__friend" placeholder="search friend here..." class="search__friend__input">
            <button type="submit" class="search__friend__button"> <i class="fas fa-search"></i> </button>
        </form>
    </section>

    <section class="friends__chat__container">

        <div class="message__firends__first__container">

            <section class="message__friends__container">

                <?php

                $friendImagePath = "../images/user.png";

                include("messagingViews/messageFriends.php");

                ?>

            </section>
        </div>


        <section class="chat__section">

            <div class="chat__friend__container">

                <p class="start__conversation">Start a conversation.</p>

            </div>

            <article class="chat__container">

                <div class="chat"></div>

            </article>

            <form action="" class="send__message__container" method="POST">

                <textarea name="" id="" cols="30" rows="10" class="user__message__input" placeholder="write a message"></textarea>


                <button type="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>

            </form>

        </section>
    </section>

</main>

<?php

$scripts = "../js/index.js";
$subScripts = "../js/messaging.js";

include("templates/headFoot/foot.php");
