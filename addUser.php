<?php // Add User To Database

session_start();

$db_hostname = 'localhost';
$db_database = 'users';
$db_username = 'JoseACabreraM';
$db_password = 'Digamma1';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if(isset($_POST['submission'])){
    if (isset($_POST['fName']) && isset($_POST['lName']) && isset($_POST['uName']) && isset($_POST['pWord']) && isset($_POST['uType'])) {
        $fName = mysqli_real_escape_string($connection, $_POST['fName']);
        $lName = mysqli_real_escape_string($connection, $_POST['lName']);
        $uName = mysqli_real_escape_string($connection, $_POST['uName']);
        $pWord = mysqli_real_escape_string($connection, $_POST['pWord']);
        $uType = mysqli_real_escape_string($connection, $_POST['uType']);
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
            header("Location:/addUser.php?error=2");
            exit();
        }
    } else {
        header("Location:/addUser.php?error=1");
        exit();
    }
} else {

    if (isset($_SESSION['uName']) && $_SESSION['uType'] == 0){
            print " 
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <title>Title</title>
                </head>
                <body style='background-color:lightgray;'>
                <div align='center'><h1> Register User </h1></div>
                <div align='center'>
                    <form action='/addUser.php ' method='POST'>
                        First name<br>
                        <input type='text' name='fName'>
                        <br> Last name<br>
                        <input type='text' name='lName'>
                        <br> Username<br>
                        <input type='text' name='uName'>
                        <br> Password<br>
                        <input type='password' name='pWord'> <br><br>
                        <input type='radio' name='uType' value='nUser'>Normal User
                        <input type='radio' name='uType' value='admin'>Admin
                        <br><br>
                        <input type='submit' value='Submit'>
                        <input type='hidden' name='submission' value='sA'>
                    </form>
                </div>
            ";

            if (isset($_GET['error'])) {
                if ($_GET['error'] == 1) {
                    print "
                        <br>
                        <div align='center'>
                            Missing fields!
                        </div>
                    ";
                } else {
                    print "
                        <br>
                        <div align='center'>
                            Username already in use!
                        </div>
                    ";
                }
            }
    } else {
        print "
            <div align='center'>
                Not authorized to access this webpage! 1
            </div>
         ";
    }
    print "
        <div align='center'>
            <br>
            <form action='mainpage.php'>   
            <button> Main Page </button> 
        </div>
        
        </form>
        </body>
        </html>
    ";
}

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