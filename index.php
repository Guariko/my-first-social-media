<?php

session_start();

if (!isset($_SESSION["userLogged"])) {
    header("location: views/loginRegister/login.php");
    die();
}

/* TODO: Database connection */

$dataBaseConnectionPath = "configs/database/databaseConnection.php";
require_once("configs/controllers/databaseClassesController.php");

/* FIXME: Database connection ends */

/* TODO: Head starts */

$normalizeCss = "css/normalize.css";
$styles = "css/styles.css";

include("views/templates/headFoot/head.php");

/* FIXME: Head ends */

/* TODO: Header starts */

$_SESSION["homePath"] = "index.php";
$_SESSION["messagingPath"] = "views/messaging.php";
$_SESSION["userImagePath"] = "images/" . $_SESSION["userData"]["user_image"];
$_SESSION["userProfilePath"] = "views/userProfile.php";

include("views/templates/header.php");

/* FIXME: Header ends */

?>

<main class="home__main main ">

    <section class="users__post__section">

        <?php

        require_once("configs/controllers/usersPostController.php");
        include("views/usersPost.php");

        ?>

    </section>

</main>

<?php

/* TODO: Foot starts */

$scripts = "js/index.js";

include("views/templates/headFoot/foot.php");

/* FIXME: Foot ends */
