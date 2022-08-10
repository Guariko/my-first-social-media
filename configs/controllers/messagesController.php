<?php

if (isset($_GET["dontUpdate"])) {
    if (isset($_SESSION["lastFriendClicked"])) {
        unset($_SESSION["lastFriendClicked"]);
        die();
    }
}

if (
    !isset($_GET["getMessages"]) && !isset($_POST["sendMessage"]) && !isset($_SESSION["lastFriendClicked"])
) {
    die();
}

if (isset($_SESSION["lastFriendClicked"])) {

    $usersData["userId"] = $_SESSION["userData"]["id"];
    $usersData["friendId"] = $_SESSION["lastFriendClicked"];
    $chatData = DataBase::getChatData($usersData);
}

if (isset($_GET["getMessages"])) {

    $usersData["userId"] = $_SESSION["userData"]["id"];
    $usersData["friendId"] = $_GET["friendId"];
    $usersData["friendId"] = filter_var($usersData["friendId"], FILTER_VALIDATE_INT);

    $chatData = DataBase::getChatData($usersData);

    $_SESSION["lastFriendClicked"] = $usersData["friendId"];
}

if (isset($_POST["sendMessage"])) {

    $messageData["from"] = $_SESSION["userData"]["id"];
    $messageData["to"] = $_POST["friendId"];
    $messageData["to"] = filter_var($messageData["to"], FILTER_VALIDATE_INT);
    $messageData["userMessage"] = strip_tags($_POST["userMessage"]);

    $usersData["userId"] = $messageData["from"];
    $usersData["friendId"] = $messageData["to"];

    DataBase::sendMessage($messageData);
    $chatData = DataBase::getChatData($usersData);
}
