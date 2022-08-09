<?php

session_start();

if (isset($_SESSION["userLogged"])) {
    header("location: ../../index.php");
}

$dataBaseConnectionPath = "../../configs/database/databaseConnection.php";
require_once("../../configs/controllers/databaseClassesController.php");

require_once("../../configs/controllers/logInController.php");

/* TODO: Head starts */

$normalizeCss = "../../css/normalize.css";
$styles = "../../css/loginRegister.css";

include("../templates/headFoot/head.php");

$signUpPath = "register.php";

/* FIXME: Head ends */

?>

<main>

    <section class="login__register__section">

        <article class="login__register__container">
            <h1 class="login__register__h1">sign in</h1>

            <form action="" class="login__register__form">

                <div class="login__register__inputs__container">
                    <div class="input__container">
                        <label for=" email">email</label>
                        <input type="text" name="email" id="email">
                    </div>

                </div>

                <div class="login__register__inputs__container">
                    <div class="input__container">
                        <label for="password">password</label>
                        <div class="login__register__password__container">
                            <input type="password" name="password" id="password">
                            <i class=" fas fa-eye"></i>
                            <i class="fas fa-eye-slash active"></i>
                        </div>
                    </div>
                    <p class="login__register__error__message <?= $displayLogInError ?> "><?= $logInErrorMessage ?></p>
                </div>

                <div class="login__register__button__container">
                    <input type="hidden" id="redirect" value="<?= $redirectValue ?>">
                    <button class="button" type="submit">sign in</button>
                </div>

            </form>

            <div class="login__register__anchor__container">
                <p class="login__register__anchor__paragraph"> Don't have an account yet? <a href="<?= $signUpPath ?>" class="login__register__anchor">sign up</a> </p>
            </div>
        </article>

    </section>

</main>

<?php

/* TODO: Foot starts */

$scripts = "../../js/loginRegister.js";

include("../templates/headFoot/foot.php");

/* FIXME: Foot ends */
