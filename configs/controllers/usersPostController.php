<?php

if (!isset($_POST["updatePostReaction"]) && !isset($_POST["seeMore"]) && !isset($_POST["addComment"])) {
    $postsData = DataBase::getAllPosts();
}

if (isset($_POST["updatePostReaction"]) || isset($_POST["seeMore"]) || isset($_POST["addComment"])) {
    session_start();
    $dataBaseConnectionPath = "../database/databaseConnection.php";
    require_once("databaseClassesController.php");
}

if (isset($_POST["updatePostReaction"])) {
    $dataToReturn = null;

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

if (isset($_POST["seeMore"])) {
    $clickedPostId = "postDataId" . $_POST["postId"];
    $originalMessage = $_SESSION[$clickedPostId]["originalMessage"];
    echo $originalMessage;
}

if (isset($_POST["addComment"])) {
    $commentData["userId"] = $_SESSION["userData"]["id"];
    $commentData["postId"] = $_POST["postId"];
    $commentData["postId"] = filter_var($commentData["postId"], FILTER_VALIDATE_INT);
    $commentData["comment"] = strip_tags($_POST["user__comment"]);
    DataBase::createComment($commentData);

    $postCommentsData = DataBase::getPostCommentsData($commentData["postId"]);
    include("commentsController.php");
}
