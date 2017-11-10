<?php // Add User To Database

$db_hostname = 'localhost';
$db_database = 'users';
$db_username = 'JoseACabreraM';
$db_password = 'Digamma1';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if (isset($_POST['fName']) && isset($_POST['lName']) && isset($_POST['uName']) && isset($_POST['pWord']) && isset($_POST['uType'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $uName = $_POST['uName'];
    $pWord = $_POST['pWord'];
    $uType = $_POST['uType'];
    $salt = "e4djuki9";
    $spWord = hash('ripemd128', "$salt$uName$pWord");
    if (!existingUser($connection, $uName)){
        if ($uType == "nUser"){
            print "Added normal user: $uName";
            addUser($connection, $fName, $lName, $uName, $spWord, 1);
        } else {
            print "Added admin: $uName";
            addUser($connection, $fName, $lName, $uName, $spWord, 0);
        }
    } else {
        print "Existing username";
    }
} else die("Missing parameters.");

function addUser($connection, $fName, $lName, $uName, $spWord, $uType) {
    $query = "INSERT INTO userData VALUES('$fName', '$lName', '$uName', '$spWord', '$uType')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}

function existingUser($connection, $uName){
    $query = "SELECT * FROM userdata WHERE username= '$uName'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        echo "<br>".$row[2]." ".$uName."<br>";
        if ($row[2] == $uName) return true;
        else return false;
    }
    return false;
}