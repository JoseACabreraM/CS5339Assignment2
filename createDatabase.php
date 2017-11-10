<?php

$db_hostname = 'localhost';
$db_database = 'users';
$db_username = 'JoseACabreraM';
$db_password = 'Digamma1';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($connection->connect_error) die($connection->connect_error);
$query = "CREATE TABLE userData (
    firstName VARCHAR(32) NOT NULL,
    lastName VARCHAR(32) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE,
    sPassword VARCHAR(32) NOT NULL UNIQUE,
    userType TINYINT(1) NOT NULL
)";
