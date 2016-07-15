<html>
<body>
<p>hello
<?php

include 'database.inc';
$user='john';
 $sql = mysql_query("SELECT STREAM FROM wtb_stream_permission WHERE USER='john' AND ALLOWED=1");
 
 //$row = mysql_fetch_array($sql); 
 echo mysql_num_rows($sql).'<br/>';
 //echo count($row).' ';
 $i=0;
 while($row[$i] = mysql_fetch_assoc($sql)){
	 #print_r($row[$i]['STREAM']);
	 echo '<a href='.$row[$i]['STREAM'].'>  Click here for camera '.$i.' </a>';
	 $i++;
	
	 echo "<br/>";
 }


?>

</p>
<?php
$clientIP = null; // provide client IP optionally
$host = "192.168.1.45"; // your ip/host
$url= "rtmp://".$host.":1935/";
$stream = "live/myStream"; // your stream
#$start = time();
#$end = strtotime("+30 minutes");  
$secret = "sharedSecret";  
$tokenName = "wowzatoken";
$hash = hash('sha256', $stream."?".$secret, true);
$base64Hash = strtr(base64_encode($hash), '+/', '-_'); 
$params = array("{$tokenName}hash=".$base64Hash);
$playbackURL = $url.$stream."?";
foreach($params as $entry){
	$playbackURL.= $entry."&";
}
$playbackURL = preg_replace("/(\&)$/","", $playbackURL);

echo $playbackURL;

?>


</body>
</html>
