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
}
