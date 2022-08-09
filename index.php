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

include("views/templates/header.php");

/* FIXME: Header ends */

/* TODO: Foot starts */

$scripts = "js/index.js";

include("views/templates/headFoot/foot.php");

/* FIXME: Foot ends */
