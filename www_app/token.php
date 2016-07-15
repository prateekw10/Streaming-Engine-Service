<?php 
$clientIP = null; // provide client IP optionally
$host = "192.168.1.45"; // your ip/host
$url= "rtmp://".$host.":1935/";
$stream = "fresh/myStream"; // your stream
$start = time();
$end = strtotime("+1 minutes");  
$secret = "sharedSecret";  
$tokenName = "wowzatoken";

$hash = "";
if(is_null($clientIP)){
	$hash = hash('sha256', $stream."?".$secret."&{$tokenName}endtime=".$end."&{$tokenName}starttime=".$start, true); // generate the hash string
}
else{
	$hash = hash('sha256', $stream."?".$clientIP."&".$secret."&{$tokenName}endtime=".$end."&{$tokenName}starttime=".$start, true); // generate the hash string
}

$base64Hash = strtr(base64_encode($hash), '+/', '-_'); 

$params = array("{$tokenName}starttime=".$start, "{$tokenName}endtime=".$end, "{$tokenName}hash=".$base64Hash);
if(!is_null($clientIP)){
	$params[] = $clientIP;
}
sort($params);
$playbackURL = $url.$stream."/playlist.m3u8?";
if(preg_match("/(rtmp)/",$url)){
	$playbackURL = $url.$stream."?";	
}

foreach($params as $entry){
	$playbackURL.= $entry."&";
}
$playbackURL = preg_replace("/(\&)$/","", $playbackURL);
echo $playbackURL;
// echo "$playbackURL"; // DEBUG - show fully formed URL 

?>
<html>
<head>
<title>JW Player Secure Token Test</title>
<script type="text/javascript" src="https://content.jwplatform.com/libraries/[LICENSE-KEY].js" ></script>
</head>

<body>

<div id="myElement">
</div>

<script type="text/javascript">
   jwplayer("myElement").setup({
       file: "<?php echo $playbackURL; ?>",
       androidhls: "true"
});
</script>
</body>
</html>
