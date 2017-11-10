<?php

session_start();

print "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Admin</title>
    </head>
    <body style=\"background-color:lightgray;\">
    
";

if (isset($_SESSION['uName'])){
    $uName = $_SESSION['uName'];
    $uType = $_SESSION['uType'];
    if ($uType == 0){
        print "
            <div 
                align='center'><h1> Admin </h1></div>
            <div>
    
            <div align='center'>
                Logged in as: $uName
                <br> <br>
                <form action='logout.php' method='post' >   
                    <input type='submit' name='Logout' value='Logout'> 
                </form>               
            </div>
                         
            <div align='center'>
                <br>
                <form action='addUser.php' method='post' >   
                    <input type='submit' name='addUser' value='Add User'> 
                </form>
            </div>
        ";
    } else {
        print "
            <div align='center'>
                Not authorized to access this webpage!
            </div>
        ";
    }
} else {
    print "
        <div align='center'>
            Not authorized to access this webpage!
        </div>
    ";
}

print "
    <div align='center'> 
        <br>
        <form action='mainpage.php'>   
            <button> Main Page </button> 
        </form>
    </div>
    </div>
    </body>
    </html>
";

