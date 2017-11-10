<?php
session_start();

print "
<div align='left'> 
    <form action='logout.php' target='_blank' method='post' >   
        <input type='submit' name='Logout' value='Logout'> 
    </form>
</div>
";

if (isset($_SESSION['uName']) && isset($_POST['sStatus'])){
    if ($_POST['sStatus'] == "Submit"){
        $remainingTime = time() - $_SESSION['timeout'];
        print "Session Uptime: ".$remainingTime;
    }
} else die ("Session expired.");
