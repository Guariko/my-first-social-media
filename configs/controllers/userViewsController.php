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
