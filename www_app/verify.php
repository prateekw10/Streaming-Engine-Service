<?php 
if(isset($_POST['submit'])){ 

	include 'database.inc';
     
    //Lets search the databse for the user name and password 
    //Choose some sort of password encryption, I choose sha256 
    //Password function (Not In all versions of MySQL). 
    $usr = mysql_real_escape_string($_POST['username']); 
    $pas = mysql_real_escape_string($_POST['password']);
	        
	// you can use http://www.xorbin.com/tools/sha256-hash-calculator to generate test sha256 hashes
	
    $sql = mysql_query("SELECT * FROM wtb_user WHERE username='$usr' AND password='$pas' LIMIT 1");

    if(mysql_num_rows($sql) == 1){ 
	    error_log('login ok');
        $row = mysql_fetch_array($sql); 
        session_start(); 
        $_SESSION['username'] = $row['username']; 
        $_SESSION['id'] = $row['ID']; 
        $_SESSION['type'] = $row['type'];
        #$_SESSION['lname'] = $row['last_name'];
        $_SESSION['logged'] = TRUE; 
       
        header("Location: video.php");
        exit; 
    } else { 
        header("Location: login.php?error=1"); 
        exit; 
    } 
} else if(isset($_REQUEST['action'])){
	$usr = mysql_real_escape_string($_REQUEST['username']); 
    $pas = mysql_real_escape_string($_REQUEST['password']);
	        
	// you can use http://www.xorbin.com/tools/sha256-hash-calculator to generate test sha256 hashes
	
    $sql = mysql_query("SELECT * FROM wtb_user WHERE username='$usr' AND password='$pas' LIMIT 1");

    if(mysql_num_rows($sql) == 1){ 
	    error_log('login ok');
        $row = mysql_fetch_array($sql); 
        session_start(); 
        $returnArray = array(
			'username' => $row['username'],
			'fname'    => $row['first_name'], 
			'lname'    => $row['last_name']
        );
        
        $rr = json_encode($returnArray);
        echo $rr; die();
	} 
}else {    // If the form button wasn't submitted go to the index page, or login page 
    header("Location: login.php");     
    exit; 
} 
?>
