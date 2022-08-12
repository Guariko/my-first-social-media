<?php

$displayCurrentPasswordError = null;
$currentPasswordErrorMessage = null;

$displayNewPasswordError = null;
$newPasswordErrorMessage = null;

$displayNewPasswordConfirmationError = null;
$newPasswordConfirmationMessageError = null;

$userPasswordValue = null;
$newPasswordValue = null;

$passwordUpdated = false;

if (isset($_POST["update__password"])) {
    session_start();

    $dataBaseConnectionPath = "../../configs/database/databaseConnection.php";
    require_once("../../configs/controllers/databaseClassesController.php");
    require_once("../../configs/controllers/userViewsController.php");
}


?>

<i class="fas fa-times"></i>

<?php if ($passwordUpdated) : ?>

    <div class="password__updated__container">
        <i class="fa-solid fa-circle-check"></i>
        <p class="password__updated__message">
            Your password has been updated successfully.
        </p>
    </div>

<?php else : ?>

    <div class="change__password__input__container">

        <input type="password" placeholder="your password" name="user__password" class="change__password__input" value="<?= $userPasswordValue ?>">
        <p class="error__message <?= $displayCurrentPasswordError ?> "> <?= $currentPasswordErrorMessage ?> </p>
    </div>

    <div class="change__password__input__container">

        <input type="password" placeholder="new password" name="new__password" class="change__password__input" value="<?= $newPasswordValue ?>">
        <p class="error__message <?= $displayNewPasswordError ?>"><?= $newPasswordErrorMessage ?></p>
    </div>

    <div class="change__password__input__container">

        <input type="password" placeholder="confirm password" name="new__password__confirm" class="change__password__input">
        <p class="error__message <?= $displayNewPasswordConfirmationError ?>"><?= $newPasswordConfirmationMessageError ?></p>
    </div>

    <button class="submit button">done</button>

<?php endif; ?>