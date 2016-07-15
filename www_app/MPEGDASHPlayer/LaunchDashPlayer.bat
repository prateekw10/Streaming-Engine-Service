@echo off
REM  Use of this batch file should only be necessary when the MPEG DASH Player page (player.html) is accessed direct through the file system instead of through a web server.

REM  Kill all Chrome instances
:loopstart
taskkill /im chrome.exe  > nul 2>&1
if %errorlevel%==0 GOTO loopstart

REM  Re-launch Chrome with --allow-file-access-from-files flag enabled
start chrome --allow-file-access-from-files "%CD%\player.html" > nul 2>&1
