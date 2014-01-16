What is it?
This is a script to chat in colorful fonts in Xonotic. This script is written for Xonotic version 0.7.0

Mechanism:
This script uses curl to call an external web server 
or a localhost server. The server prints a script to assign speak variable. Curl downloads the output script into dlcache folder. 
Finally, to show the chat input, the downloaded script is just executed using exec command.

Setup:
1. Setting up the Xonotic script:
Create autoexec.cfg in C:\Users\YourUsername\Saved Games\xonotic\data under windows or $HOME/.Xonotic/data under linux. Place color_text.cfg in a folder and call it from 
autoexec.cfg using the command exec /~folder path/color_text.cfg. Or simply copy paste the code under color_text.cfg into autoexec.cfg.
2. Setting up the Webserver:
Download and install xampp server (portable is good enough) or any other server that supports php.
Then, place speakx.php in your server directory - usually in htdocs folder under Xampp. 
Usage:
1. Press O to input chat for public OR press P to input chat for team. 
2. If you want input chat in console, use say1 command followed by your text for public chat or say2 command followed by your text for team chat .

Important: 
Clear *.chat files from dlcache folder before running nexuiz. One good way is to run xonotic with a batch script which clears the chat files
and calls xonotic client. E.g in windows create a xonotic.bat file inside nexuiz folder and add the following two lines to the file:

del "C:\Users\YourUsername\Saved Games\xonotic\data\dlcache\*.chat"
xonotic.exe

Then every time you want to run xonotic just run xonotic.bat file.
Caution:
i) There are some obvious limitations since an web address is used as an input chat. For instance the input "+" is lost during the web transaction, 
instead %2B should be used.


