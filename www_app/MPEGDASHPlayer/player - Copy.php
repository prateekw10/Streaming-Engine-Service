<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<?php
session_start();
if(!$_SESSION['logged']){ 
    header("Location: ../../login.php"); 
    exit; 
}
$id=$_SESSION['id'];
?>

<html lang="en">
<head>
	<script src="jquery.min.js"></script>
	<script src="demo.js"></script>
	
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>MPEG-DASH Player - Live Video Streaming | Wowza Media Systems</title>

    <script language="javascript">AC_FL_RunContent = 0;</script>

    <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="css/wowza.css" type="text/css" />

    <!-- Libraries -->

    <!-- DASH-AVC/265 reference implementation -->
    <script src="js/shaka-player.js"></script>

    <!-- Framework CSS -->
    <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="css/wowza.css" type="text/css" />

    <script>
        function supports_media_source()
        {
            "use strict";
            var hasWebKit = (window.WebKitMediaSource !== null && window.WebKitMediaSource !== undefined),
                hasMediaSource = (window.MediaSource !== null && window.MediaSource !== undefined);
            return (hasWebKit || hasMediaSource);
        }
    </script>

</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="span-18">
            <h1>Live Video Streaming</h1>
            <h2>MPEG-DASH Player</h2>
        </div>
        
        <hr class="heading">
        <!-- END HEADER -->
        <!-- EXAMPLE PLAYER: WIDTH of this player should be 630px, height will vary depending on the example-->
        <div class="span-16">
            
            <div id="supported" style="display:none">
                <div>
                    <style>
                        video {
                            background-color: #000000;
                        }
                    </style>
                   <video id="videoObj" x-webkit-airplay="allow" controls alt="Example File" width="300" height="200" autoplay></video> 
                </div>
                
              <p>Playback position: <span id="demo"></span></p>
               
              
               <p>Final time:<span id="demo1"></span></p>
              <p>Buffer time:<span id="demo2"></span></p>
              <p>time to check:<span id="demo3"></span></p>
                      
              
				
				
                <table>
			<!--
                    <tr>
                        <td>
                            <button id="playObj" type="button" style="width:50px" onclick="JavaScript:playControl()" disabled="disabled">Pause</button>
                        </td>
                    </tr>
			-->
                    <tr>
                        <td align="right">
                            <b>Stream:</b>
                        </td>
                        <td>

                            <!-- <input id="connectStr" size = "56" type="text" placeholder="" value="<?php  echo $_SESSION['MPEGstream'];?>"/> -->
                            <input id="connectStr" size = "56" type="text" placeholder="" value="<?php  echo json_decode($_REQUEST['data']); ?>"/>
                            <button id="connectObj" type="button" style="width:80px" onclick="JavaScript:connect()">Start</button>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <b>Status:</b>
                        </td>
                        <td>
                            <label id="statusStr" size = "100" type="text" placeholder="" value="">Disconnected</label>
                        </td>
                    </tr>
                </table>
            </div>
			<div id="debug_log" style="height: 425px; width: 630px; overflow: auto; clear: both;">
			</div>
       <script>
            
            if ( supports_media_source() ) {
                supported.style.display="";
                videoObj.style.display="";
            }
            else {
                notsupported.style.display="";
            }
		

            function connect()
            {
                if(connectObj.textContent == "Stop") 
			{
				       
					   dashStop();
				       connectObj.textContent = "Start";
					   statusStr.textContent = "Disconnected";
                	}
                else {  

                        connectObj.textContent = "Stop";
                        statusStr.textContent = "Playing";
                        if ( video == null )
                        { video = document.querySelector("video"); }

                        if ( player == null )
                        { player = new shaka.player.Player(video); }

                        // Attach the player to the window so that it can be easily debugged.
                        window.player = player;

                        // Listen for errors from the Player.
                        player.addEventListener('error', failed );

                        // Construct a DashVideoSource to represent the DASH manifest.
                        //var mpdUrl = 'http://turtle-tube.appspot.com/t/t2/dash.mpd';
                        if ( estimator != null )
			{ estimator=null; }
                        estimator = new shaka.util.EWMABandwidthEstimator();

                        if ( source != null )
                        { source = null; }

                        source = new shaka.player.DashVideoSource(connectStr.value, null, estimator);

                        // Load the source into the Player.
                        player.load(source);
                    }// is allowed if condition
                	}
            }

	function failed(e)
	{
	var done = false;
	if ( e.detail == 'Error: Network failure.' )
		{
		statusStr.textContent = 'Network Connection Failed.';
		done = true;
		}
        if ( e.detail.status!=200 && done == false )
                {
		switch ( e.detail.status )
			{
			case 404:
			statusStr.textContent = e.detail.url+' not found.';
			break;
			default:
	                statusStr.textContent = 'Error '+e.detail.status+' for '+e.detail.url;
			break;
                	}
		}
        }

	function dashStop()
	{
		if(player!=null)
		{
		player.unload();
		}
	connectObj.textContent = "Start";
	statusStr.textContent = "Disconnected";
	}

            </script>
        </div>
        <!-- SIDEBAR -->
        
        <!-- END FOOTER -->
    </div>
    
</body>
</html>
