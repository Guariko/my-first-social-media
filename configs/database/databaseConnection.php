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
}
