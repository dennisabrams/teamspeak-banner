<?php

/*
 * Configuration file for ts3-banner.php
 *
 * Author: Dennis Abrams
 * Repository: https://github.com/dennisabrams/teamspeak3-banner
 *
 */

// TS3 PHP framework path
$ts3_libary = '../vendor/planetteamspeak/ts3-php-framework/libraries/TeamSpeak3/TeamSpeak3.php'; // Default path: libraries/TeamSpeak3/TeamSpeak3.php

// Serverquery connection
$serverquery_username = 'serveradmin'; // Default serverquery_username: 'serveradmin'
$serverquery_password = 'PASSWORD'; // Password
$server_ip = '127.0.0.1'; // Set to '127.0.0.1' if the webserver and TS3 server are hosted on the same server (localhost)
$serverquery_port = '10011'; // Default serverquery_port: '10011'
$server_port = '9987'; // Default server_port: '9987'

// TS3 Bots
$ts3_bots = 0; // Amount of Bots on the TS3 server

// Admins online
$admin = 0; // Shows the amout of admins inside a box: 1 = Enabled, 0 = Disabled
$admin_id = 0; // Group icon ID from the Admins

// Locale information
date_default_timezone_set('Europe/Berlin'); // Locale date information
setlocale(LC_ALL, 'de_DE.utf8'); // Locale date spelling
$date_type = 1; // 0 = Numeric representation (01.01.2023), 1 = Textual representation (01 January 2023)

// Background image
$background = 'images/background.png'; // Background image path (3:1 aspect ratio)
$blur_background = 0; // Add a blur filter over the background: 1 = Enabled, 0 = Disabled
$blur_intensity = 10; // Blur intensity

// Text config
$font = 'fonts/ReadexPro.ttf'; // Font style path
$ascii = 1; // Allow only ASCII characters for server/user names : 1 = Enabled, 0 = Disabled
$text_time = 130; // Size of the current time
$text_server = 100; // Size of the server name
$text_normal = 50; // Size of the headlines
$text_small = 40; // Size of informations
$text_color1 = [255, 255, 255, 0]; // Custom text color RGBA [Red, Green, Blue, Alpha]
$text_color2 = [105, 108, 124, 0]; // Custom text color RGBA [Red, Green, Blue, Alpha]
$text_distance = 10; // Distance between the bottom text infos
$line_thickness = 0.5; // Line thickness
$custom = ""; // Custom text (\n = new line)
$text_custom = 2; // Size of the custom text

// Box color
$box = [0, 0, 0, 70]; // Custom box color RGBA [Red, Green, Blue, Alpha]

// Logo image (if there is no logo it will just show the name of the server)
$logo = ''; // Logo image path
$logo_size = 70; // Logo size

// Server version
$version = 1; // 1 = Enabled, 0 = Disabled

// Server host
$host_name = 1; // Shows the server host name inside a box: 1 = Enabled, 0 = Disabled

// Server group icons (more info: server_groups/README.md)
$groups = 0; // 1 = Enabled, 0 = Disabled
$max_groups = 5; // Maximum of server group icons that will be shown
$gpl = 9; // Distance left (0 - 100)
$bad_groups = []; // Icon ID's you don't want to show e.g. if they are invisible: [ID number, ID number, ...]

// Translation
$t1 = 'Bandwith (last min)'; // 'Bandwith (last min)'
$t2 = 'Connection information'; // 'Connection information'
$t3 = 'Upload (Bytes/s)'; // 'Upload (Bytes/s)'
$t4 = 'Download (Bytes/s)'; // 'Download (Bytes/s)'
$t5 = 'Nickname'; // 'Nickname'
$t6 = 'Connected since'; // 'Connected since'
$t7 = 'Total connections'; // 'Total connections'
$t8 = 'Groups'; // 'Groups'
$t9 = 'Clients'; // 'Clients'
$t10 = 'Channels'; // 'Channels'
$t11 = 'Workload'; // 'Workload'
$t12 = 'Uptime'; // 'Uptime'
$t13 = 'Last joined'; // 'Last joined'
$t14 = 'No client info'; // 'No client info'
$t15 = "Check if you are connected \nto a VPN or proxy server and \nreconnect to"; // "Check if you are connected \nto a VPN or proxy server and \nreconnect to"

?>
