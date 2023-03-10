<?php

/*
 * Configuration file for ts3-banner.php
 *
 * Author: Dennis Abrams
 * Repository: https://github.com/dennisabrams/teamspeak3-banner
 *
 */

// TS3 PHP framework path
$ts3_libary = "../vendor/planetteamspeak/ts3-php-framework/libraries/TeamSpeak3/TeamSpeak3.php"; // Default path: libraries/TeamSpeak3/TeamSpeak3.php

// Serverquery connection
$serverquery_username = "serveradmin"; // Default serverquery_username: "serveradmin"
$serverquery_password = "PASSWORD"; // Password
$server_ip = "127.0.0.1"; // Set to "127.0.0.1" if the webserver and TS3 server are hosted on the same server (localhost)
$serverquery_port = "10011"; // Default serverquery_port: "10011"
$server_port = "9987"; // Default server_port: "9987"

// TS3 Bots
$ts3_bots = 0; // Amount of Bots on the TS3 server

// Locale information
date_default_timezone_set("Europe/Berlin"); // Locale date information
setlocale(LC_ALL, "de_DE.utf8"); // Locale date spelling

// Background image
$background = "images/background.png"; // Background image path (3:1 aspect ratio)

// Text config
$font = "fonts/ReadexPro.ttf"; // Font style path
$text_time = 130; // Size of the current time
$text_server = 100; // Size of the server name
$text_normal = 50; // Size of the headlines
$text_small = 40; // Size of informations
$text_color1 = array("R" => 255, "G" => 255, "B" => 255, "A" => 0); // Custom text color RGBA (Red, Green, Blue, Alpha)
$text_color2 = array("R" => 105, "G" => 108, "B" => 124, "A" => 0); // Custom text color RGBA (Red, Green, Blue, Alpha)

// Box color
$box = array("R" => 0, "G" => 0, "B" => 0, "A" => 70); // Custom box color RGBA (Red, Green, Blue, Alpha)

// Logo image (if  there is no logo it will just shows the name of the server)
$logo = ""; // Logo image path
$logo_size = 100; // Logo size

// Custom Text
$custom = ""; // Custom text (\n = new line)
$its = ""; // Custom text size
$itr = ""; // Custom text rotation (0 - 360)
$ipl = ""; // Distance left (0 - 100)
$ipt = ""; // Distance top (0 - 100)

// Server version
$version = 1; // 1 = Enabled, 0 = Disabled

// Server group icons (more info: server_groups/README.md)
$groups = 0; // 1 = Enabled, 0 = Disabled
$max_groups = 5; // Maximum of server group icons that will be shown
$gpl = 9; // Distance left (0 - 100)
$bad_groups = array(); // Icon ID's you don't want to show e.g. if they are invisible: array(ID, ID, ...)

// Translation
$t1 = "Bandwith (last min)"; // "Bandwith (last min)"
$t2 = "Connection information"; // "Connection information"
$t3 = "Upload (Bytes/s)"; // "Upload (Bytes/s)"
$t4 = "Download (Bytes/s)"; // "Download (Bytes/s)"
$t5 = "Nickname"; // "Nickname"
$t6 = "Connected since"; // "Connected since"
$t7 = "Total connections"; // "Total connections"
$t8 = "Groups"; // "Groups"
$t9 = "Clients"; // "Clients"
$t10 = "Channels"; // "Channels"
$t11 = "Workload"; // "Workload"
$t12 = "Uptime"; // "Uptime"
$t13 = "No client info"; // "No client info"
$t14 = "Check if you are connected \nto a VPN or proxy server and \nreconnect to"; // "Check if you are connected \nto a VPN or proxy server and \nreconnect to"

?>
