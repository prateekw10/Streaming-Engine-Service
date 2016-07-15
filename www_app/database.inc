<?php

    $dbHost = "localhost";      //Location Of Database usually its localhost 
    $dbUser = "new_user";           //Database User Name 
    $dbPass = "abc";         //Database Password 
    $dbDatabase = "wtbexampledb";    //Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database.");
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 

?>
