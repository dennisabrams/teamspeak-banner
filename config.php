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
$serverquery_password = "PASSWORD";
$server_ip = "127.0.0.1"; // Set to "127.0.0.1" if the webserver and TS3 server are hosted on the same server (localhost)
$serverquery_port = "10011"; // Default serverquery_port: "10011"
$server_port = "9987"; // Default server_port: "9987"

// TS3 Bots
$ts3_bots = 0; // Amount of Bots on the TS3 server

// Locale information
date_default_timezone_set("Europe/Berlin"); // Locale date information
setlocale(LC_ALL, "de_DE.utf8"); // Locale date spelling

// Background Image
$background = "images/background.png"; // Background Image Path

// Text Config
$font = "fonts/ReadexPro.ttf"; // Font style Path
$text_large = 130; // Size of the current time
$text_normal = 50; // Size of the headlines
$text_small = 40; // Size of informations
$text_color1 = array("R" => 255, "G" => 255, "B" => 255); // Custom text color RGB (0 - 255)
$text_color2 = array("R" => 105, "G" => 108, "B" => 124); // Custom text color RGB (0 - 255)

// Logo Image (If  there is no Logo it will just show the name of the server)
$logo = ""; // Logo Image Path for example: images/logo.png
$logo_size = 50; // Logo size in percentage
$logo_transparency = 100; // Logo Transparency (0 - 100)
$lpl = "30"; // Distance left (0 - 100)
$lpt = "30"; // Distance top (0 - 100)

// Server Name
$sts = "100"; // Server text size
$spl = "36"; // Distance left (0 - 100)
$spt = "53"; // Distance top (0 - 100)

// Custom Text
$custom = ""; // Custom text (\n = new line)
$its = ""; // Custom text size
$itr = ""; // Custom text rotation (0 - 360)
$ipl = ""; // Distance left (0 - 100)
$ipt = ""; // Distance top (0 - 100)

// Server Version
$version = 1; // 1 = Enabled, 0 = Disabled

// Server Group Icons
$groups = 0; // 1 = Enabled, 0 = Disabled
$max_groups = 5; // Maximum of Server Group Icons that will be shown
$gpl = 9; // Distance left (0 - 100)

// Translation
$t1 = "Bandwith (last min.)"; // Bandwith (last min.)
$t2 = "Connection Information"; // Connection Information
$t3 = "Upload (Bytes/s)"; // Upload (Bytes/s)
$t4 = "Download (Bytes/s)"; // Download (Bytes/s)
$t5 = "Nickname"; // Nickname
$t6 = "Connected since"; // Connected since
$t7 = "Total Connections"; // Total Connections
$t8 = "Groups"; // Groups
$t9 = "Clients"; // Clients
$t10 = "Channels"; // Channels
$t11 = "Uptime" // Uptime

?>
