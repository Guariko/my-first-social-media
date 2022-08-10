<?php

session_start();

$dataBaseConnectionPath = "../../configs/database/databaseConnection.php";
require_once("../../configs/controllers/databaseClassesController.php");

require_once("../../configs/controllers/messagesController.php");

if ($chatData) {
    foreach ($chatData as $data) :

        if ($data["from_user"] === $_SESSION["userData"]["id"]) {
            $chatMessageClass = "user__message";
        } else {
            $chatMessageClass = "friend__message";
        }
?>

        <p class="<?= $chatMessageClass ?> message "> <?= $data["message"] ?> </p>

<?php endforeach;
}
