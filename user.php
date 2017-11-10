<?php

session_start();

print "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Users Page</title>
    </head>
    <body style=\"background-color:lightgray;\">
    
";

if (isset($_SESSION['uName'])){
    $uName = $_SESSION['uName'];
    print "
        <div 
            align='center'><h1> Users Page </h1></div>
        <div>

        <div align='center'>
            Logged in as: $uName
            <br> <br>
            <form action='logout.php' method='post' >   
                <input type='submit' name='Logout' value='Logout'> 
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

