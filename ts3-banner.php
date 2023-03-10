<?php

/*
 * ts3-banner.php
 *
 * Author: Dennis Abrams
 * Repository: https://github.com/dennisabrams/teamspeak3-banner
 *
 */

require_once('config.php');
require_once($ts3_libary);

$connected = FALSE;

// Serverquery connection
try {
	// Connect to the server, authenticate and spawn an object for the virtual server on the specific port
	// Encode username and password to RFC 3986 if there are any special characters inside
	$ts3 = TeamSpeak3::factory("serverquery://" .rawurlencode($serverquery_username) .":" .rawurlencode($serverquery_password) ."@$server_ip:$serverquery_port/?server_port=$server_port");

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
		// Comparing IP's if client is connected to the TS3 server
		if ($cl->getProperty('connection_client_ip') == $_SERVER['REMOTE_ADDR']) {
			$client = $cl->client_nickname;
			// Convert ms in min and add 1 extra min because TS3 shows the image only after the GTX interval is over
			$connected_time = (round(($cl->connection_connected_time) / 60000) + 1);
			$total_connections = $cl->client_totalconnections;
			$upload = $cl->connection_bandwidth_sent_last_minute_total;
			$download = $cl->connection_bandwidth_received_last_minute_total;
			$country = strtolower($cl->client_country);
			$server_group = $cl->client_servergroups;
			$connected = TRUE;
		}
	}
}

catch (Exception $e) {
	// If serverquery connection failed
	die('<pre><b>Error Code: '.$e->getCode() .'</b> ' .$e->getMessage().'</pre>');
}

// Convertion
$connected_hours = floor($connected_time / 60);
$connected_min = $connected_time - ($connected_hours * 60);
$server_uptime = str_replace("D", "d", $server_uptime);
$server_uptime = substr($server_uptime, 0, -3);
$server_uptime = str_replace(":", "h ", $server_uptime) ."min";
$server_group = array_map('intval', explode(',', $server_group));
$load = sys_getloadavg();

// Image generation
$banner = imagecreatefromstring(file_get_contents($background));
list($width, $height) = getimagesize($background);
$w = $width / 100;
$h = $height / 100;
$color1 = imagecolorallocatealpha($banner, $text_color1["R"], $text_color1["G"], $text_color1["B"], $text_color1["A"]);
$color2 = imagecolorallocatealpha($banner, $text_color2["R"], $text_color2["G"], $text_color2["B"], $text_color2["A"]);
$color3 = imagecolorallocatealpha($banner, $box["R"], $box["G"], $box["B"], $box["A"]);
$flag = imagecreatefrompng("flags/" .$country .".png");

// Image drawing
imagefilledrectangle($banner, $w*78, $h*50.8, $w*96, $h*50, $color1);
imagefilledrectangle($banner, $w*0, $h*87.3, $w*100, $h*100, $color3);
imagettftext($banner, $its, $itr, $w*$ipl, $h*$ipt, $color1, $font, $custom);
imagettftext($banner, $text_time, 0, $w*80, $h*45, $color1, $font, date('H:i'));
imagettftext($banner, $text_small, 0, $w*83.3, $h*60, $color1, $font, strftime("%x"));
if (empty($logo)) {
	$t_box = imagettfbbox($text_server, 0, $font, $server_name);
	// Centered server name text
	imagettftext($banner, $text_server, 0, ($width - (abs($t_box[2]) - abs($t_box[0]))) / 2, ($height - (abs($t_box[5]) - abs($t_box[3]))) / 1.75, $color1, $font, $server_name);
}
else {
	$logoimg = imagecreatefromstring(file_get_contents($logo));
	list($logo_width, $logo_height) = getimagesize($logo);
	$ml= $width - $logo_width / 100 * $logo_size;
	$mt = $height - $logo_height / 100 * $logo_size;
	$logoimg = imagescale($logoimg, $logo_width / 100 * $logo_size, $logo_height / 100 * $logo_size, IMG_BICUBIC);
	imagecopy($banner, $logoimg, $ml / 2, $mt / 2, 0, 0, $logo_width / 100 * $logo_size, $logo_height / 100 * $logo_size);
}

// Draw client info
if ($connected) {
	imagettftext($banner, $text_normal, 0, $w*2, $h*15, $color2, $font, $t1);
	imagettftext($banner, $text_small, 0, $w*2, $h*25, $color2, $font, $t3 .": " .$upload);
	imagettftext($banner, $text_small, 0, $w*2, $h*31, $color2, $font, $t4 .": " .$download);
	imagettftext($banner, $text_normal, 0, $w*2, $h*50, $color2, $font, $t2);
	imagettftext($banner, $text_small, 0, $w*2, $h*60, $color2, $font, $t5 .": " .$client);
	if ($connected_hours >= 1) {
		imagettftext($banner, $text_small, 0, $w*2, $h*66, $color2, $font, $t6 .": " .$connected_hours." h " .$connected_min ." min");
	}
	else {
		imagettftext($banner, $text_small, 0, $w*2, $h*66, $color2, $font, $t6 .": " .$connected_min ." min");
	}
	imagettftext($banner, $text_small, 0, $w*2, $h*72, $color2, $font, $t7 .": " .$total_connections);
	$flag = imagescale($flag, 90, 60, IMG_BICUBIC);
	imagefilledellipse($banner, $w*87.7, $h*74.6, 165, 165, $color3);
	imagecopymerge($banner, $flag, $w*86.2, $h*72, 0, 0, 90, 60 , 100);
	if (!empty($groups)) {
		imagettftext($banner, $text_small, 0, $w*2, $h*78, $color2, $font, $t8 .": ");
		for ($i = 0, $x_groups = $w*$gpl; $i < $max_groups; $i++, $x_groups += 65) {
			for ($j = 0; $j < sizeof($bad_groups); $j++) {
				if ($server_group[$i] == $bad_groups[$j]) {
					array_splice($server_group, $i, 1);
				}
			}
			$group = imagecreatefrompng("server_groups/".$server_group[$i].".png");
			$group = imagescale($group, 60, 60, IMG_BICUBIC);
			$bg_image = imagecreatetruecolor(60, 60);
			$bg_color = imagecolorallocate($bg_image, 0, 0, 0);
			imagefill($bg_image, 0, 0, $bg_color);
			imagecopy($bg_image, $group, 0, 0, 0, 0, 60, 60);
			imagecolortransparent($bg_image, $bg_color);
			imagecopymerge($banner,$bg_image, $x_groups, $h*73.5, 0, 0, 60, 60 , 100);
		}
		if (sizeof($server_group) > $max_groups) {
			imagettftext($banner, $text_small, 0, $x_groups + 10, $h*78, $color2, $font, "...");
		}
	}
}
else {
	// Client connection problem
	imagettftext($banner, $text_normal, 0, $w*2, $h*40, $color2, $font, $t13);
	imagettftext($banner, $text_small, 0, $w*2, $h*50, $color2, $font, $t14 ." " .$server_name);
}

// Draw server info
imagettftext($banner, 45, 0, $w*2, $h*96, $color1, $font, $t9 .": " .$total_clients .' / ' .$max_clients);
imagettftext($banner, 45, 0, $w*27, $h*96, $color1, $font, $t10 .": " .$total_channels);
imagettftext($banner, 45, 0, $w*50, $h*96, $color1, $font, $t11 .": " .$load[0] ."%");
imagettftext($banner, 45, 0, $w*76, $h*96, $color1, $font, $t12 .": " .$server_uptime);
if (!empty($version)) {
	imagefilledpolygon($banner, array($w*89,  0, $width, $h*23, $width, 0), 3, $color3);
	imagettftext($banner, 40, -37, $w*94.6, $h*5.6, $color2, $font, $server_version);
}

// Returns the image in the browser
header('Content-type: image/png');
imagepng($banner);
imagedestroy($banner, $flag, $bg_image, $group);

?>
