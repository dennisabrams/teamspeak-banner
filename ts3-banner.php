<?php

require_once('config.php');
require_once($ts3_libary); // Load TS3 PHP framework files

$connected = FALSE;

// Serverquery connection
try {

	$ts3= TeamSpeak3::factory("serverquery://$serverquery_username:$serverquery_password@$server_ip:$serverquery_port/?server_port=$server_port");

	// Get server Info
	$server_name = $ts3->virtualserver_name;
	$server_uptime = TeamSpeak3_Helper_Convert::seconds($ts3->virtualserver_uptime);
	$server_version = strtok($ts3->virtualserver_version, ' ');
	$total_channels = $ts3->virtualserver_channelsonline;
	$total_clients = $ts3->virtualserver_clientsonline - $ts3->virtualserver_queryclientsonline - $ts3_bots;
	$max_clients = $ts3->virtualserver_maxclients;

	// Get client Info
	foreach ($ts3->clientList() as $cl) {

		if ($cl->client_type) continue;

		if ($cl->getProperty('connection_client_ip') == $_SERVER['REMOTE_ADDR']) { // Comparing IP's
			$client = $cl->client_nickname;
			$connected_time = (round(($cl->connection_connected_time) / 60000) + 1); // Convert ms in min and add 1 extra min because TS3 shows the image only after the GTX interval is over
			$total_connections = $cl->client_totalconnections;
			$upload = $cl->connection_bandwidth_sent_last_minute_total; // Bytes/s
			$download = $cl->connection_bandwidth_received_last_minute_total;
			$country = strtolower($cl->client_country); // Country in lower case for flag images
			$server_group = $cl->client_servergroups;
			$connected = TRUE;
		}
	}
}

catch (Exception $e) {
	// If Serverquery connection failed
	die('<pre><b>Error Code: '.$e->getCode() .'</b> ' .$e->getMessage().'</pre>');
}

// Convertion
$connected_hours = floor($connected_time / 60);
$connected_min = $connected_time - ($connected_hours * 60);
$server_uptime = str_replace("D", "d", $server_uptime);
$server_uptime = substr($server_uptime, 0, -3); // Remove seconds
$server_uptime = str_replace(":", "h ", $server_uptime) ."min";
$server_group = array_map('intval', explode(',', $server_group));

// Image generation
$banner = imagecreatefrompng($background);
list($width, $height) = getimagesize($background);
$w = $width / 100;
$h = $height / 100;
$white = imagecolorallocate($banner, 255, 255, 255);
$gray = imagecolorallocate($banner, 105, 108, 124);
$flag = imagecreatefrompng("flags/" .$country .".png");

// Image drawing
imageline($banner, $w*78, $h*50, $w*96, $h*50, $white);
imageline($banner, $w*0, $h*88, $w*100, $h*88, $gray);
imageline($banner, $w*89, 0, $width, $h*23, $gray);
imagettftext($banner, $sts, 0, $w*$spl, $h*$spt, $white, $font, $server_name); // Server name
imagettftext($banner, 130, 0, $w*80, $h*45, $white, $font, date('H:i')); // Time
imagettftext($banner, 40, 0, $w*82.5, $h*60, $white, $font, strftime("%x")); // Date

// Draw client info
if ($connected) {
	imagettftext($banner, 50, 0, $w*2, $h*15, $gray, $font, "Bandbreite letzte Minute");
	imagettftext($banner, 40, 0, $w*2, $h*25, $gray, $font, "Upload (Bytes/s): " .$upload);
	imagettftext($banner, 40, 0, $w*2, $h*31, $gray, $font, "Download (Bytes/s): " .$download);
	imagettftext($banner, 50, 0, $w*2, $h*50, $gray, $font, "Verbindungsinformationen");
	imagettftext($banner, 40, 0, $w*2, $h*60, $gray, $font, "Nickname: " .$client);
	if ($connected_hours >= 1) {
		imagettftext($banner, 40, 0, $w*2, $h*66, $gray, $font, "Verbunden seit: " .$connected_hours." h, " .$connected_min ." min.");
	}
	else {
		imagettftext($banner, 40, 0, $w*2, $h*66, $gray, $font, "Verbunden seit: " .$connected_min ." min.");
	}
	imagettftext($banner, 40, 0, $w*2, $h*72, $gray, $font, "Totale Verbindungen: " .$total_connections);
	$flag = imagescale($flag, 90, 60, IMG_BICUBIC); // Bildgröße ändern
	imagecopymerge($banner, $flag, $w*2, $h*76, 0, 0, 90, 60 , 100); // Bild in Bild einfügen
}

// Draw server info
imagettftext($banner, 30, -38, $w*95, $h*4, $gray, $font, "Server");
imagettftext($banner, 30, -37, $w*94, $h*7, $gray, $font, "v. " .$server_version);
imagettftext($banner, 45, 0, $w*2, $h*96, $white, $font, "Clients: " .$total_clients .' / ' .$max_clients);
imagettftext($banner, 45, 0, $w*45, $h*96, $white, $font, "Channels: " .$total_channels);
imagettftext($banner, 45, 0, $w*76, $h*96, $white, $font, "Uptime: " .$server_uptime);

// Returns the image in the browser
header('Content-type: image/png');
imagepng($banner);
imagedestroy($banner, $flag, $festtag, $backgroundImg, $rolle);

?>