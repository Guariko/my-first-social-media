<?php

require_once($dataBaseConnectionPath);

$dataBaseConnectionObject = new DataBaseConnectionClass();
$dataBaseConnection = $dataBaseConnectionObject->connection();

DataBase::initialize(new DataBaseClass($dataBaseConnection));
