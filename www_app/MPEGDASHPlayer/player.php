<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<?php
session_start();
if(!$_SESSION['logged']){ 
    header("Location: ../../login.php"); 
    exit; 
}?>

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
        <div class="span-6 last">
            <a href="http://www.wowza.com"><img src="img/wowza-logo_1024.png" class="logo" style="height:72px;width:205px" /></a>
        </div>
        <hr class="heading">
        <!-- END HEADER -->
        <!-- EXAMPLE PLAYER: WIDTH of this player should be 630px, height will vary depending on the example-->
        <div class="span-16">
            <div id="notsupported" style="display:none">
                <br/>
                <br/>
                <br/>
                <h2><b>The MediaSource API is not supported by this browser</b></h2>
                <br/>
                <h3>Please view in a browser that supports the MediaSource API, such as Google Chrome.</h3>
                <br/>
                <br/>
            </div>
            <div id="supported" style="display:none">
                <div>
                    <style>
                        video {
                            background-color: #000000;
                        }
                    </style>
                    <video id="videoObj" x-webkit-airplay="allow" controls alt="Example File" width="630" height="354" autoplay></video>
                </div>
                
              <p>Playback position: <span id="demo"></span></p>
               
              
               <p>Final time:<span id="demo1"></span></p>
              <p>Buffer time:<span id="demo2"></span></p>
              <p>time to check:<span id="demo3"></span></p>
                      
                <script> 
                   //  document.getElementById("demo4").innerHTML = Date.now();
            /*    var time1 ;
                var time2;
                var time,total=0;
						// Get the video element with id="myVideo"
						var vid = document.getElementById("videoObj");
                        
						// Assign an ontimeupdate event to the video element, and execute a function if the current playback position has changed
						vid.onplaying = function() {myFunction1()};
                        vid.onwaiting = function() {myFunction2()};
                         
						function myFunction1() {
						// Display the current position of the video in a p element with id="demo"
						time1=Date.now();
						//document.getElementById("demo").innerHTML = time1;
							}
							
							function myFunction2() {
						// Display the current position of the video in a p element with id="demo"
						time2=Date.now();
						time = time2-time1;
						total=total+time;
						document.getElementById("demo").innerHTML = total;
							}
				*/
				</script>
				
				
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
                            <input id="connectStr" size = "56" type="text" placeholder="" value="<?php  echo json_decode($_REQUEST['data']);?>"/>
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
            
           var time1,buffer_flag=0 ;
           var buffer_flag,buffer_time=0,buffer_time1=0,buffer_time2=0,buffer_total=0;
                var time2;
                var time,total=0;
                var flag=0,start,end;
						// Get the video element with id="myVideo"
						var vid = document.getElementById("videoObj");
                        
						// Assign an ontimeupdate event to the video element, and execute a function if the current playback position has changed
						vid.onplaying = function() {myFunction1()};
                        vid.onwaiting = function() {myFunction2()};
                        window.addEventListener("beforeunload", function (e) {

                        if(connectObj.textContent == "Stop")
                                connect();

                        });
                       // vid.ontimeupdate = function() {myFunction3()};
                       // window.onbeforeunload = function() {connect()};
                         
                        function myFunction() {
                            if(connectObj.textContent == "Stop")
                                connect();
                        }

						function myFunction1() {
						// Display the current position of the video in a p element with id="demo"
						time1=Date.now();
                        buffer_flag=0;
						//document.getElementById("demo").innerHTML = time1;
							}
							
							function myFunction2() {
						// Display the current position of the video in a p element with id="demo"
						time2=Date.now();
                       // buffer_time1=time2;
						time = time2-time1;
						total=total+time;
						document.getElementById("demo").innerHTML = total;
                        buffer_flag=1;
							}

                          /*  function myFunction3() {
                                document.getElementById("demo3").innerHTML = Date.now() - start - buffer_total;
                                if(Date.now() - start - buffer_total > 30 )
                                {
                                    //alert("Your time limit has exceeded");
                                    connect();
                                    buffer_total=0;
                                    buffer_time1=0;
                                    buffer_time2=0;

                                }
                            }*/
            
            if ( supports_media_source() ) {
                supported.style.display="";
                videoObj.style.display="";
            }
            else {
                notsupported.style.display="";
            }
		var video;
		var player;
		var source; 
		var estimator;
        var id;
        var isAllowed=true;

         function myTimer() {

           if(buffer_flag==0)    {
                       time2=Date.now(); 
                       time=time2-time1;
                       total=total+time;  }
                      else
                       {
                         //  buffer_time2=Date.now();

                           //buffer_time+=(buffer_time2-buffer_time1);
                       
                     //  buffer_time=buffer_time2-buffer_time1;
                       //buffer_total+=buffer_time;
                   }
                       
                       document.getElementById("demo1").innerHTML = total;
                      // document.getElementById("demo2").innerHTML = buffer_total;
                      // alert(start);
                       //alert(end);
                      // alert(total);
                       $.ajax({
                        url : 'demo.php',
                        type:'POST',
                        data :{
                        action:"update","v1":total,"v2":id},
                        success:function(data){ 
                       // alert(data);
                        func1();
                        }    
                    }); 

                   

                      function func1()  {
                      isAllowed = true;
                        $.ajax({
                        url : 'demo.php',
                        type:'POST',
                        data :{
                        action:"getData","v1":Date.now()},
                        success:function(data){
                       //     alert(data);

                           if(data=='1') isAllowed = true; 
                            else isAllowed = false;
                            func(isAllowed);
                        }
                    }); 
                        function func(isAllowed)  {
                      //  alert(isAllowed);
                        if(isAllowed==false)
                        {
                            if(connectObj.textContent == "Stop")
                              { // clearInterval(myVar);
                                dashStop();
                                connectObj.textContent = "Start";
                                statusStr.textContent = "Disconnected";
                              }
                        }
                        else
                        {
                            if(connectObj.textContent == "Start")
                                connect();
                            flag=1;
                        }   
                    }
                }
                     start=end;
                     
         }

            function connect()
            {
                if(connectObj.textContent == "Stop") 
			{
				       flag=0;
                   //clearInterval(myVar);
                  if(buffer_flag==0)    {
                       time2=Date.now(); 
                       time=time2-time1;
                       total=total+time;  }
                      else
                       {
                           //buffer_time2=Date.now();
                           buffer_flag=0;
                           //buffer_time+=(buffer_time2-buffer_time1);
                       }
                      // buffer_time=buffer_time2-buffer_time1;
                      // buffer_total+=buffer_time;
                       //end=Date.now();
                       document.getElementById("demo1").innerHTML = total;
                     //  document.getElementById("demo2").innerHTML = buffer_total;
                       isAllowed=false;

		             $.ajax({
						url : 'demo.php',
						type:'POST',
						data :{
						action:"updateEnd","v1":total,"v2":id,"v3":Date.now()},
						success:function(data){	
					//	alert(data);
                       // func3();
						}	 
					}); 
                        
                       function func3() {
                        $.ajax({
                        url : 'demo.php',
                        type:'POST',
                        data :{
                        action:"getData"},
                        success:function(data){
                           // alert(data);

                            if(1==Integer.parseInt(data)) isAllowed = true; 
                            else isAllowed = false;
                        }
                    }); 
                     //   alert(isAllowed);
					    }
					   dashStop();
				       connectObj.textContent = "Start";
					   statusStr.textContent = "Disconnected";
                	}
                else {  if(isAllowed==true) {
					      total=0;
                          var myVar = setInterval(myTimer,60000);
                          start=Date.now();
                          $.ajax({
                        url : 'demo.php',
                        type:'POST',
                        data :{
                        action:"store","v1":start},
                        success:function(data){ 
                        //alert(data);
                        id=data;
                        
                        }    
                    }); 
                        flag=0;

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
        <div class="span-7 prepend-1 last">
            <h3>Description</h3>
            <p>This example contains source code for an MPEG-DASH player using the Shaka Player package from the <a href="https://github.com/google/shaka-player">Shaka Player project</a>. It will play MPEG-DASH single and adaptive bitrate VOD MP4 streams.</p> 
            <p><strong>Warning:</strong> You may experience inconsistent playback using this third-party beta DASH test player.</p>
            <h3>Installation</h3>
            <p>In the /examples/LiveVideoStreaming  directory:<br>
            <ul>
                <li>LINUX<br>
                    Run <strong>./installall.sh</strong>
                <li>WINDOWS 7 / WINDOWS 8<br>
                    Right-click <strong>installall.bat</strong> and then select <strong>Run as administrator</strong>
                <li>WINDOWS SERVER<br>
                    Double-click the <strong>installall.bat</strong> file                 
                <li>OS X<br>
                    Double-click the <strong>installall.command</strong> file
                </ul>
            <h3>Instructions</h3>
            <ol>
                <li>Read the Tutorials below.
                <li>Make sure that the URL in the <strong>Stream</strong> field is correct.
                <li>Click the <strong>Connect</strong> button.
            </ol>
            <h3>Tutorials</h3>
            <ul>
                <li><a href="http://www.wowza.com/forums/content.php?376-How-to-play-your-first-live-stream-%28video-tutorial%29">How to play your first live stream (video tutorial)</a>
                <li><a href="http://www.wowza.com/forums/content.php?37-How-to-publish-and-play-a-live-stream-%28MPEG-TS-based-encoder%29">How to publish and play a live stream (MPEG-TS based encoder)</a>
                <li><a href="http://www.wowza.com/forums/content.php?39-How-to-re-stream-video-from-an-IP-camera-%28RTSP-RTP-re-streaming%29">How to re-stream video from an IP camera (RTSP/RTP re-streaming)</a>
                <li><a href="http://www.wowza.com/forums/content.php?38-How-to-set-up-live-streaming-using-a-native-RTP-encoder-with-SDP-file">How to set up live streaming using a native RTP encoder with SDP file</a>
                <li><a href="http://www.wowza.com/forums/content.php?36-How-to-set-up-live-streaming-using-an-RTMP-based-encoder">How to set up live streaming using an RTMP-based encoder</a>
                <li><a href="http://www.wowza.com/forums/content.php?354-How-to-set-up-live-streaming-using-an-RTSP-RTP-based-encoder">How to set up live streaming using an RTSP/RTP-based encoder</a>
            </ul>
            <h3>Additional Resources</h3>
            <ul>
                <li><a href="http://www.wowza.com/docredirect.php?doc=tutorialMPEGDASH">MPEG-DASH Streaming</a></li>
                <li><a href="http://www.wowza.com/forums/content.php?8-live-streaming-and-encoders">Live Streaming and Encoders Articles</a>
                <li><a href="http://www.wowza.com/forums/forumdisplay.php?38-Live-Streaming-and-Encoder-Discussion">Live Streaming and Encoders Forums</a>
                <li><a href="http://www.wowza.com/forums/content.php?573-Record-Live-Streams">Recording Live Streams</a>
            </ul>
        </div>
        <!-- FOOTER -->
        <div class="span-24">
            <hr class="heading">
            <div class="span-1">
            	<img src="img/icon-company.png" width="32" height="32" />
            </div>
            <div class="span-23 last copyright">
                &nbsp;&#169;&nbsp;2007&ndash;2016 Wowza Media Systems&#8482;, LLC. All rights reserved.
            </div>
        </div>
        <!-- END FOOTER -->
    </div>
    
</body>
</html>
