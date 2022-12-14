<?php

$nameErrorMessage = null;
$emailErrorMessage = null;
$passwordErrorMessage = null;

$displayNameError = null;
$displayEmailError = null;
$displayPasswordError = null;

$nameValue = null;
$emailValue = null;
$passwordValue = null;

$nameMinLength = 4;
$nameMaxLength = 20;

$passwordMinLength = 8;
$passwordMaxLength = 100;

$redirectValue = null;

if (isset($_POST["signUp"])) {

    $userName = strip_tags($_POST["name"]);
    $userEmail = $_POST["email"];
    $userEmail = filter_var($userEmail, FILTER_VALIDATE_EMAIL);
    $userPassword = strip_tags($_POST["password"]);

    $error = false;
    $userData = [];

    if (strlen($userName) < $nameMinLength) {
        $displayNameError = "active";
        $nameErrorMessage = "Your nickname must have at least 4 characters.";
        $error = true;
    }

    if (strlen($userName) > $nameMaxLength) {
        $displayNameError = "active";
        $nameErrorMessage = "Your nickname cannot have more than 20 characters.";
        $error = true;
    }

    if (!$userEmail) {
        $displayEmailError = "active";
        $emailErrorMessage = "Please, enter a valid email.";
        $error = true;
    }

    if (strlen($userPassword) < $passwordMinLength) {
        $displayPasswordError = "active";
        $passwordErrorMessage = "Your password must have at least 8 characters.";
        $error = true;
    }

    if (strlen($userPassword) > $passwordMaxLength) {
        $displayPasswordError = "active";
        $passwordErrorMessage = "Your password cannot have more than 100 characters.";
        $error = true;
    }

    if (!$displayNameError) {
        $nameValue = $userName;
    }

    if (!$displayEmailError) {
        if (DataBase::emailExists($userEmail)) {
            $error = true;
            $displayEmailError = "active";
            $emailErrorMessage = "This email already exists.";
        } else {
            $emailValue = $userEmail;
        }
    }

    if (!$displayPasswordError) {
        $passwordValue = $userPassword;
    }

    if (!$error) {

        $userData["name"] = $userName;
        $userData["email"] = $userEmail;
        $userData["password"] = $userPassword;

        DataBase::createUser($userData);
        $redirectValue = "login.php";
    }
}
