<?php
/* Configuration file for ts3-dynamic-banner */

// TS3 PHP framework path
$ts3_libary = '../vendor/planetteamspeak/ts3-php-framework/libraries/TeamSpeak3/TeamSpeak3.php'; // Default path: libraries/TeamSpeak3/TeamSpeak3.php

// Serverquery connection
$serverquery_username = 'serveradmin'; // Default serverquery_username: 'serveradmin'
$serverquery_password = '';
$server_ip = '127.0.0.1'; // Set to '127.0.0.1' if the webserver and TS3 server are hosted on the same server (localhost)
$serverquery_port = '10011'; // Default serverquery_port: '10011'
$server_port = '9987'; // Default server_port: '9987'

// TS3 Bots
$ts3_bots = 1; // Amount of Bots on the TS3 server

// Locale information
date_default_timezone_set(''); // Locale date information
setlocale(LC_ALL, 'de_DE.utf8'); // Locale date spelling

// Background Image
$background = 'background.png';

// Logo Image
$logo = 'logo.png';
$lpl = '';
$lpt = '';

// If there is no Logo it will just show the name of the server
$sts = '100'; // Server text size
$spl = '36'; // Server name padding left (0% - 100%)
$spt = '53'; // Server name padding top (0% - 100%)

// Text Config
$font = 'fonts/ReadexPro.ttf';
$text_large = 150; // Size of the current time
$text_normal = 50; // Size of the headlines
$text_small = 40; // Size of informations
?>