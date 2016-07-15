#!/bin/bash

# Use of this batch file should only be necessary when the MPEG DASH Player page (player.html) is accessed directly through the file system instead of through a web server.

kill $(ps ax | grep 'Chrome' | awk '{print $1}') >& /dev/null 
count=2 
while [ $count -ge 2 ] 
do 
count=$(ps ax | grep -c 'Chrome' ) 
done

open -a "Google Chrome" --args -allow-file-access-from-files /Library/WowzaStreamingEngine/examples/LiveVideoStreaming/MPEGDASHPlayer/player.html >& /dev/null &


