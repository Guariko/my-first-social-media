<?php

if (isset($_POST["update__password"])) {

    $passwordMinLength = 8;
    $passwordMaxLength = 100;

    $displayError = "active";

    $error = false;
    $userPassword = strip_tags($_POST["user__password"]);
    $newPassword = strip_tags($_POST["new__password"]);
    $newPasswordConfirm = strip_tags($_POST["new__password__confirm"]);

    if ($userPassword !== $_SESSION["userData"]["password"]) {
        $displayCurrentPasswordError = $displayError;
        $currentPasswordErrorMessage = "Incorrect password";
        $error = true;
    }

    if (strlen($newPassword) < $passwordMinLength) {
        $displayNewPasswordError = $displayError;
        $newPasswordErrorMessage = "Your password must have at least 8 characters";
        $error = true;
    }

    if (strlen($newPassword) > $passwordMaxLength) {
        $displayNewPasswordError = $displayError;
        $newPasswordErrorMessage = "Your password cannot have more than 100 characters";
        $error = true;
    }

    if ($newPassword === $userPassword) {
        $displayNewPasswordError = $displayError;
        $newPasswordErrorMessage = "Your new password cannot be equal to the current one";
        $error = true;
    }

    if ($newPassword !== $newPasswordConfirm) {
        $displayNewPasswordConfirmationError = $displayError;
        $newPasswordConfirmationMessageError = "The passwords are different";
        $error = true;
    }

    if ($displayCurrentPasswordError !== $displayError) {
        $userPasswordValue = $userPassword;
    }

    if ($displayNewPasswordError !== $displayError) {
        $newPasswordValue = $newPassword;
    }

    if (!$error) {
        $userData["newPassword"] = $newPassword;
        $userData["userId"] = $_SESSION["userData"]["id"];
        DataBase::updateUserPassword($userData);
        $_SESSION["userData"]["password"] = $userData["newPassword"];

        $passwordUpdated = true;
    }
}

if (isset($_POST["displayPostImage"])) {

    session_start();

    $postImageName = $_FILES["post__image"]["name"];
    $postImageSize = $_FILES["post__image"]["size"];
    $postImageError = $_FILES["post__image"]["error"];
    $postImageTmpName = $_FILES["post__image"]["tmp_name"];

    $noError = 0;
    $minPostImageSize = 200000;
    $error = "error";

    if ($postImageError === $noError) {

        if ($postImageSize <= $minPostImageSize) {

            $allowExtensions = ["png", "jpg", "jpeg"];
            $postImageExtension = strtolower(pathinfo($postImageName, PATHINFO_EXTENSION));

            if (in_array($postImageExtension, $allowExtensions)) {
                $newPostImageName = uniqid("IMG-", true) . "." . $postImageExtension;
                $postImagePath = "../../images/postImages/" . $newPostImageName;

                move_uploaded_file($postImageTmpName, $postImagePath);
                $_SESSION["post_image"] = $newPostImageName;
                echo $newPostImageName;
            } else {
                echo $error;
            }
        } else {
            echo $error;
        }
    } else {
        echo $error;
    }
}

if (isset($_POST["startPost"])) {

    session_start();

    $dataBaseConnectionPath = "../database/databaseConnection.php";
    require_once("databaseClassesController.php");

    if (isset($_SESSION["post_image"])) {
        $postData["post_image"] = $_SESSION["post_image"];
    } else {
        $postData["post_image"] = false;
    }

    $postMessageMinLength = 1;
    $postMessageMaxLength = 3000;

    $error = false;

    $postMessage =  strip_tags($_POST["post__content"]);

    if (strlen($postMessage) < $postMessageMinLength ||  strlen($postMessage) > $postMessageMaxLength) {
        $error = true;
    }

    if (!$error) {
        $postData["message"] = $postMessage;
        $postData["user_id"] = $_SESSION["userData"]["id"];

        DataBase::startPost($postData);
        echo "success";
        unset($_SESSION["post_image"]);
    } else {
        echo "error";
    }
}

if (isset($_POST["unsetPostImage"])) {
    session_start();

    if (isset($_SESSION["post_image"])) {
        unlink("../../images/postImages/" . $_SESSION["post_image"]);
        unset($_SESSION["post_image"]);
        echo "Hello world";
    } else {
        echo "testing";
    }
}
