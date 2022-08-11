<?php

if (isset($_FILES["user__image__data"])) {

    session_start();

    $dataBaseConnectionPath = "../database/databaseConnection.php";
    require_once("databaseClassesController.php");

    $noErrors = 0;
    $userImageMinSize = 125000;

    $userImageName = $_FILES["user__image__data"]["name"];
    $userImageSize = $_FILES["user__image__data"]["size"];
    $userImageTmpName = $_FILES["user__image__data"]["tmp_name"];
    $userImageError = $_FILES["user__image__data"]["error"];

    $error = "error";

    if ($userImageError === $noErrors) {
        if ($userImageSize <= $userImageMinSize) {
            $allowExtensions = ["jpg", "png", "jpeg"];
            $userImageExtension = strtolower(pathinfo($userImageName, PATHINFO_EXTENSION));

            if (in_array($userImageExtension, $allowExtensions)) {
                $newImageName = uniqid("IMG-", true) . "." . $userImageExtension;
                $imagePath = "../../images/" . $newImageName;
                move_uploaded_file($userImageTmpName, $imagePath);

                $userData["newUserImage"] = $newImageName;
                $userData["userId"] = $_SESSION["userData"]["id"];
                DataBase::updateUserImage($userData);

                if ($_SESSION["userData"]["user_image"] !== "user.png") {
                    unlink("../../images/" . $_SESSION["userData"]["user_image"]);
                }

                $_SESSION["userData"]["user_image"] = $userData["newUserImage"];

                echo ($_SESSION["userImagePath"] = "../images/" . $_SESSION["userData"]["user_image"]);
            } else {
                echo $error;
                die();
            }
        } else {
            echo $error;
            die();
        }
    } else {
        echo $error;
        die();
    }
}
