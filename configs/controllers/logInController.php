<?php

$redirectValue = null;
$displayLogInError = null;
$logInErrorMessage = null;

$userPasswordMinLength = 8;
$userPasswordMaxLength = 100;

if (isset($_POST["signIn"])) {

    $userEmail = $_POST["email"];
    $userEmail = filter_var($userEmail, FILTER_VALIDATE_EMAIL);

    $userPassword = strip_tags($_POST["password"]);

    $error = false;

    if ((strlen($userPassword) < $userPasswordMinLength) ||
        (strlen($userPassword) > $userPasswordMaxLength) ||
        (!$userEmail)
    ) {
        $error = true;
        $displayLogInError = "active";
        $logInErrorMessage = "Invalid email or password";
    }

    if ($userEmail) {
        if (!DataBase::emailExists($userEmail)) {
            $error = true;
            $displayLogInError = "active";
            $logInErrorMessage = "Invalid email or password";
        }
    }

    if (!$error) {

        $userData["email"] = $userEmail;
        $userData["password"] = $userPassword;

        if (DataBase::isUser($userData)) {

            $_SESSION["userLogged"] = true;
            $_SESSION["userData"] = DataBase::getUserData($userData["email"]);

            $redirectValue = "../../index.php";
        } else {
            $displayLogInError = "active";
            $logInErrorMessage = "Invalid email or password";
        }
    }
}
