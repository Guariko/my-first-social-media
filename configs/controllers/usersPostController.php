<?php

if (!isset($_POST["updatePostReaction"])) {
    $postsData = DataBase::getAllPosts();
}

if (isset($_POST["updatePostReaction"])) {

    session_start();

    $dataToReturn = null;

    $dataBaseConnectionPath = "../database/databaseConnection.php";
    require_once("databaseClassesController.php");

    $reactionData["userId"] = $_SESSION["userData"]["id"];
    $reactionData["postId"] = $_POST["postReactionId"];
    $reactionData["postId"] = filter_var($reactionData["postId"], FILTER_VALIDATE_INT);

    $reactionExists = DataBase::reactionExists($reactionData);

    DataBase::updateReaction($reactionData);

    if ($reactionExists) {
        DataBase::deleteReaction($reactionData);
    } else {
        DataBase::createReaction($reactionData);
        $dataToReturn = "active,";
    }

    echo  $dataToReturn .= DataBase::getPostReactions($reactionData["postId"])["reactions"];
}
