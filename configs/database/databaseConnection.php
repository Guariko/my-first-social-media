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
}
