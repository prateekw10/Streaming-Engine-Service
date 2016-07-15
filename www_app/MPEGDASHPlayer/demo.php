<?php
if(isset($_REQUEST['action'])){
	if($_REQUEST['action']=="store"){
		storeData($_REQUEST['v1'],$_REQUEST['v2']);
	}
	if($_REQUEST['action']=="getData"){
		getData($_REQUEST['v1'],$_REQUEST['v2']);
	}
	if($_REQUEST['action']=="update") {
		updateData($_REQUEST['v1'],$_REQUEST['v2']);
	}
	if($_REQUEST['action']=="updateEnd") {
		updateEnd($_REQUEST['v1'],$_REQUEST['v2'],$_REQUEST['v3']);
	}
}

function updateData($para1,$para2){
	include 'database.inc';
		$para2=(int)$para2;
		$para1=(int)$para1;
	$sql = "UPDATE `user_minutes` SET `duration`=$para1 WHERE `id`=$para2";
	if (!mysql_query($sql)) {
    	$error = "Error: " . $sql . "<br>" . mysql_error($db);
    	echo $error; die();
	}
	echo $para2." ".$sql;
	//echo $row;
}

function updateEnd($para1,$para2,$para3){
	include 'database.inc';
		$para2=(int)$para2;
	$sql = "UPDATE `user_minutes` SET `duration`=$para1, `end`=$para3 WHERE `id`=$para2";
	if (!mysql_query($sql)) {
    	$error = "Error: " . $sql . "<br>" . mysql_error($db);
    	echo $error; die();
	}
	echo $para2." ".$sql;
	//echo $row;
}

function getData($para1,$para2){
	include 'database.inc';
	$total=0;	
	$para1=(int)$para1;
	//echo gettype($para1);
    $para1-=180000;
	$sql = "select duration from user_minutes where start>$para1 and user=$para2";
	$result = mysql_query($sql);
	while($row=mysql_fetch_assoc($result)){
		$total+= (double)$row['duration'];
	}
	//echo $total;
	//echo "-";
	if($total>60000)
		echo "0";
	else 
		echo "1";
	//echo $row;
}


function storeData($para1,$para2){
include 'database.inc';	
	#echo "successfully stored".$para; 
	$para1 = (double)$para1;
     #$para2 = (double)$para2;
     #$para3 = (double)$para3;
	#$sql = "UPDATE wtbexampledb.`user_minutes` SET `duration`=$para1, `start`=$para2, `end`=$para3 WHERE `user`='john'";
     $sql = "INSERT `user_minutes` ( `start`,`user`) VALUES ($para1,$para2)";
    // echo $sql;
	if (!mysql_query($sql)) {
    	$error = "Error: " . $sql . "<br>" . mysql_error($db);
    	echo $error; die();
	}
	$id=mysql_insert_id()."";
	echo $id;
	#echo $para1;
	#echo $sql;
}
?>