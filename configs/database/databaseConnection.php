<?php

class DataBaseConnectionClass
{

    private $dbName = "my_social_media";
    private $host = "localhost";
    private $port = "3306";
    private $userName = "root";
    private $userPassword = "fisscomS1000";
    private $dataBaseConnection;

    public function connection()
    {

        $this->dataBaseConnection = null;

        try {
            $this->dataBaseConnection = new PDO(
                "mysql:dbname=" . $this->dbName .
                    ";host=" . $this->host .
                    ";port=" . $this->port,
                $this->userName,
                $this->userPassword
            );
            $this->dataBaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error" . $e->getMessage();
        }

        return $this->dataBaseConnection;
    }
}

class DataBaseClass
{

    private $dataBaseConnection;

    public function __construct($dataBaseConnection)
    {
        $this->dataBaseConnection = $dataBaseConnection;
    }

    public function createUser($userData)
    {
        $sql = "INSERT INTO users(name, password, email, datetime)
                VALUES(:name, :password, :email, now())";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":name" => $userData["name"],
            ":email" => $userData["email"],
            ":password" => $userData["password"],
        ]);
    }

    public function emailExists($email)
    {

        $sql = "SELECT email FROM users WHERE email LIKE :email LIMIT 1";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":email" => $email,
        ]);

        if ($smt->fetch()) {
            return true;
        }

        return false;
    }

    public function isUser($userData)
    {
        $sql = "SELECT email, password FROM users WHERE email LIKE :email AND password LIKE :password LIMIT 1";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":email" => $userData["email"],
            ":password" => $userData["password"],
        ]);

        if ($smt->fetch()) {
            return true;
        }

        return false;
    }

    public function getUserData($email)
    {
        $sql = "SELECT * FROM users WHERE email LIKE :email LIMIT 1";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":email" => $email,
        ]);

        return $smt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsersData($userId)
    {
        $sql = "SELECT * FROM users WHERE id != :userId ";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute(
            [
                ":userId" => $userId,
            ]
        );

        return $smt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendMessage($messageData)
    {

        $sql = "INSERT INTO messages (from_user, to_user, message, datetime) VALUES(:from_user, :to_user, :message, now())";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":from_user" => $messageData["from"],
            ":to_user" => $messageData["to"],
            ":message" => $messageData["userMessage"]
        ]);
    }

    public function getChatData($usersData)
    {
        $sql = "SELECT * FROM messages WHERE (from_user LIKE :userId OR from_user LIKE :friendId) AND (to_user LIKE :friendId OR to_user LIKE :userId)";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":userId" => $usersData["userId"],
            ":friendId" => $usersData["friendId"],
        ]);

        return $smt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortFriends($friendName, $userId)
    {
        $sql = "SELECT * FROM users WHERE name REGEXP (:name) AND id != :userId";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":name" => $friendName,
            "userId" => $userId,
        ]);

        return $smt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUserImage($userData)
    {
        $sql = "UPDATE users SET user_image = :newUserImage WHERE id LIKE :userId";
        $smt = $this->dataBaseConnection->prepare($sql);

        $smt->execute([
            ":newUserImage" => $userData["newUserImage"],
            ":userId" => $userData["userId"],
        ]);
    }

    public function updateUserPassword($userData)
    {
        $sql = "UPDATE users SET password = :newPassword WHERE id LIKE :userId";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":newPassword" => $userData["newPassword"],
            ":userId" => $userData["userId"],
        ]);
    }

    public function startPost($postData)
    {
        if ($postData["post_image"]) {
            $sql = "INSERT INTO posts(message, post_image, datetime, user_id) VALUES (:message, :post_image, now(), :user_id)";
            $smt = $this->dataBaseConnection->prepare($sql);
            $smt->execute([
                ":message" => $postData["message"],
                ":post_image" => $postData["post_image"],
                ":user_id" => $postData["user_id"],
            ]);
        } else {
            $sql = "INSERT INTO posts(message, datetime, user_id) VALUES (:message, now(), :user_id)";
            $smt = $this->dataBaseConnection->prepare($sql);
            $smt->execute([
                ":message" => $postData["message"],
                ":user_id" => $postData["user_id"],
            ]);
        }
    }

    public function getAllPosts()
    {
        $sql = "SELECT * FROM posts ORDER BY id DESC";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute();

        return $smt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserDataById($userId)
    {
        $sql = "SELECT * FROM users WHERE id LIKE :id LIMIT 1";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":id" => $userId,
        ]);

        return $smt->fetch(PDO::FETCH_ASSOC);
    }

    public function createReaction($reactionData)
    {
        $sql = "INSERT INTO reactions(user_id, post_id, datetime) VALUES(:userId, :postId, now())";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":userId" => $reactionData["userId"],
            ":postId" => $reactionData["postId"],
        ]);
    }

    public function updateReaction($reactionData)
    {

        $reactionExists = $this->reactionExists($reactionData);

        $sql = "UPDATE posts SET reactions = reactions + 1 WHERE id LIKE :postId";

        if ($reactionExists) {
            $sql = "UPDATE posts SET reactions = reactions - 1 WHERE id LIKE :postId";
        }

        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":postId" => $reactionData["postId"],
        ]);
    }

    public function reactionExists($reactionData)
    {
        $sql = "SELECT * FROM reactions WHERE user_id LIKE :userId AND post_id LIKE :post_id LIMIT 1";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":userId" => $reactionData["userId"],
            ":post_id" => $reactionData["postId"],
        ]);

        return $smt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteReaction($reactionData)
    {
        $sql = "DELETE FROM reactions WHERE user_id LIKE :userId && post_id LIKE :postId";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":userId" => $reactionData["userId"],
            ":postId" => $reactionData["postId"],
        ]);
    }

    public function getPostReactions($postId)
    {
        $sql = "SELECT reactions FROM posts WHERE id LIKE :postId LIMIT 1";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":postId" => $postId,
        ]);

        return $smt->fetch(PDO::FETCH_ASSOC);
    }

    public function createComment($commentData)
    {
        $sql = "INSERT INTO comments(user_id, post_id, comment, datetime) VALUES(:userId, :postId, :comment, now())";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":userId" => $commentData["userId"],
            ":postId" => $commentData["postId"],
            ":comment" => $commentData["comment"],

        ]);

        $this->updateAmountComments($commentData["postId"]);
    }

    private function updateAmountComments($postId)
    {
        $sql = "UPDATE posts SET comments = comments + 1 WHERE id LIKE :postId";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":postId" => $postId,
        ]);
    }

    public function getPostCommentsData($postId)
    {
        $sql = "SELECT * FROM comments WHERE post_id LIKE :postId ORDER BY id DESC";
        $smt = $this->dataBaseConnection->prepare($sql);
        $smt->execute([
            ":postId" => $postId,
        ]);

        return $smt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class DataBase
{

    static private $dataBaseConnection;

    static public function initialize(DataBaseClass $dataBaseObject)
    {
        return self::$dataBaseConnection = $dataBaseObject;
    }

    static public function createUser($userData)
    {
        return self::$dataBaseConnection->createUser($userData);
    }

    static public function emailExists($email)
    {
        return self::$dataBaseConnection->emailExists($email);
    }

    static public function isUser($userData)
    {
        return self::$dataBaseConnection->isUser($userData);
    }

    static public function getUserData($email)
    {
        return self::$dataBaseConnection->getUserData($email);
    }

    static public function getAllUsersData($userId)
    {
        return self::$dataBaseConnection->getAllUsersData($userId);
    }

    static public function sendMessage($messageData)
    {
        return self::$dataBaseConnection->sendMessage($messageData);
    }

    static public function getChatData($usersData)
    {
        return self::$dataBaseConnection->getChatData($usersData);
    }

    static public function sortFriends($friendName, $userId)
    {
        return self::$dataBaseConnection->sortFriends($friendName, $userId);
    }

    static public function updateUserImage($userData)
    {
        return self::$dataBaseConnection->updateUserImage($userData);
    }

    static public function updateUserPassword($userData)
    {
        return self::$dataBaseConnection->updateUserPassword($userData);
    }

    static public function startPost($postData)
    {
        return self::$dataBaseConnection->startPost($postData);
    }

    static public function getAllPosts()
    {
        return self::$dataBaseConnection->getAllPosts();
    }

    static public function getUserDataById($userId)
    {
        return self::$dataBaseConnection->getUserDataById($userId);
    }

    static public function createReaction($reactionData)
    {
        return self::$dataBaseConnection->createReaction($reactionData);
    }

    static public function updateReaction($reactionData)
    {
        return self::$dataBaseConnection->updateReaction($reactionData);
    }

    static public function reactionExists($reactionData)
    {
        return self::$dataBaseConnection->reactionExists($reactionData);
    }

    static public function deleteReaction($reactionData)
    {
        return self::$dataBaseConnection->deleteReaction($reactionData);
    }

    static public function getPostReactions($postId)
    {
        return self::$dataBaseConnection->getPostReactions($postId);
    }

    static public function createComment($commentData)
    {
        return self::$dataBaseConnection->createComment($commentData);
    }

    static public function getPostCommentsData($postId)
    {
        return self::$dataBaseConnection->getPostCommentsData($postId);
    }
}
