<?php

$db_hostname = 'localhost';
$db_database = 'users';
$db_username = 'JoseACabreraM';
$db_password = 'Digamma1';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if (isset($_POST['uName']) && isset($_POST['pWord'])) {
    $uName = mysqli_real_escape_string($connection, $_POST['uName']);
    $pWord = mysqli_real_escape_string($connection, $_POST['pWord']);
    if (existingUser($connection, $uName) && verifyUser($connection, $uName, $pWord)) {
        header("Location:/mainpage.php");
        exit();
    } else {
        header("Location:/login.php?error=1");
        exit();
    }
} else {
    header("Location:/login.php?error=1");
    exit();
}

function existingUser($connection, $uName){
    $query = "SELECT * FROM userdata WHERE username= '$uName'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        if ($row[2] == $uName) return true;
        else return false;
    }
    return false;
}

function verifyUser($connection, $uName, $pWord){
    $query = "SELECT * FROM userdata WHERE username= '$uName'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $salt = "e4djuki9";
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        $spWord = $row[3];
        if ($spWord == hash('ripemd128', "$salt$uName$pWord")){
            session_start();
            $_SESSION['uName'] = $uName;
            $_SESSION['fName'] = $row[0];
            $_SESSION['lName'] = $row[1];
            $_SESSION['uType'] = $row[4];
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function printUserData($connection, $uName){
    print "<br>"."Username:".$_SESSION['uName']."<br>";
    print "<br>".$_SESSION['fName']." ".$_SESSION['lName']."<br>";
}