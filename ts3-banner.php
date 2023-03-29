<?php

/*
 * ts3-banner.php
 *
 * Author: Dennis Abrams
 * Repository: https://github.com/dennisabrams/teamspeak3-banner
 *
 */

require_once('config.php');
require_once('drawing.php');
require_once($ts3_libary);

// Serverquery connection
try {
	// Connect to the server, authenticate and spawn an object for the virtual server on the specific port
	// Encode username and password to RFC 3986 so special characters will be converted
	$ts3 = TeamSpeak3::factory('serverquery://' .rawurlencode($serverquery_username) .':' .rawurlencode($serverquery_password) ."@$server_ip:$serverquery_port/?server_port=$server_port");

	// Get server Info
	$server_name = $ts3->virtualserver_name;
	$server_uptime = TeamSpeak3_Helper_Convert::seconds($ts3->virtualserver_uptime);
	$server_version = strtok($ts3->virtualserver_version, ' ');
	$total_channels = $ts3->virtualserver_channelsonline;
	$total_clients = $ts3->virtualserver_clientsonline - $ts3->virtualserver_queryclientsonline - $ts3_bots;
	$max_clients = $ts3->virtualserver_maxclients;

	// Get client IP
	$ip = isset($_SERVER['HTTP_CLIENT_IP'])
	? $_SERVER['HTTP_CLIENT_IP']
	: (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
		? $_SERVER['HTTP_X_FORWARDED_FOR']
		: $_SERVER['REMOTE_ADDR']);

	// Get client Info
	$connected = FALSE;
	$admin_count = 0;
	$i = 0;
	foreach ($ts3->clientList() as $cl) {
		if ($cl->client_type) continue;
		$last_time[] = $cl->connection_connected_time;
		$last_user[] = $cl->client_nickname;
		$admin[] = array_map('intval', explode(',', $cl->client_servergroups));
		if (in_array($admin_id, $admin[$i])) {
			$admin_count++;
		}

		// Comparing IP's if client is connected to the TS3 server
		if ($cl->getProperty('connection_client_ip') == $ip) {
			$client = $last_user[$i];
			// Convert ms in min and add 1 extra min because TS3 shows the image only after the GTX interval is over
			$connected_time = (round(($last_time[$i]) / 60000) + 1);
			$total_connections = $cl->client_totalconnections;
			$upload = $cl->connection_bandwidth_sent_last_minute_total;
			$download = $cl->connection_bandwidth_received_last_minute_total;
			$country = strtolower($cl->client_country);
			$server_group = array_map('intval', explode(',', $cl->client_servergroups));
			$connected = TRUE;
		}
		$i++;
	}
}

// Serverquery connection failed
catch (Exception $e) {
	die('<pre><b>Error Code: '.$e->getCode() .'</b> ' .$e->getMessage().'</pre>');
}

// Convertion
$connected_hours = floor($connected_time / 60);
$connected_min = $connected_time - ($connected_hours * 60);
$server_uptime = str_replace('D', 'd', $server_uptime);
$server_uptime = substr($server_uptime, 0, -3);
$server_uptime = str_replace(':', 'h ', $server_uptime) .'min';
$load = sys_getloadavg();
$date = $date_type == 1 ? strftime('%d %B %Y') : strftime('%x');
$last_user = $last_user[array_search(min($last_time), $last_time)];
$last_time = (round(min($last_time) / 60000) + 1);
$last_time > 60 ? $last_time = '60+' : $last_time;
for ($i = 0; $i < $text_distance; $i++) $spacer .= ' ';
if (!empty($ascii)) {
	$last_user = preg_replace('/[^[:ascii:]]/', '', $last_user);
	$client = preg_replace('/[^[:ascii:]]/', '', $client);
	$server_name = preg_replace('/[^[:ascii:]]/', '', $server_name);
}

// Image generation
$banner = imagecreatefromstring(file_get_contents($background));
for ($i = 0; !empty($blur_background) && $i < $blur_intensity; $i++) {
	imagefilter($banner, IMG_FILTER_GAUSSIAN_BLUR);
}
list($width, $height) = getimagesize($background);
$w = $width / 100;
$h = $height / 100;
$color1 = imagecolorallocatealpha($banner, $text_color1[0], $text_color1[1], $text_color1[2], $text_color1[3]);
$color2 = imagecolorallocatealpha($banner, $text_color2[0], $text_color2[1], $text_color2[2], $text_color2[3]);
$color3 = imagecolorallocatealpha($banner, $box[0], $box[1], $box[2], $box[3]);

// Draw server info
empty($logo)
	? drawtext($banner, 2.5, $color1, $font, $w, $h, $server_name, 2, 2.2)
	: drawimg($banner, $width, $height, $logo, $logo_size);
imagefilledrectangle($banner, $w*0, $h*87.3, $w*100, $h*100, $color3);
imagefilledrectangle($banner, $w*73, $h*14, $w*92, $h*27, $color3);
imagefilledpolygon($banner, [$w*78, $h*27, $w*88, $h*27, $w*85, $h*29, $w*80, $h*29], 4, $color3);
if (!empty($host_name)) {
	imagefilledpolygon($banner, [$w*33, $h*87.3, $w*38, $h*74.6, $w*62, $h*74.6, $w*67, $h*87.3], 4, $color3);
	drawtext($banner, 1.2, $color2, $font, $w, $h, $_SERVER['SERVER_NAME'], 2, 1.22);
}
if (!empty($admin)) {
	imagefilledpolygon($banner, [$w*31, 0, $w*38, $h*12.7, $w*62, $h*12.7, $w*69, 0], 4, $color3);
	drawtext($banner, 1.2, $color2, $font, $w, $h, 'Admins Online: ' .$admin_count, 2, 16);
}
drawtext($banner, 1.2, $color1, $font, $w, $h, $t9 .': ' .$total_clients .' / ' .$max_clients .$spacer
.$t10 .': ' .$total_channels .$spacer .$t11 .': ' .$load[0] .'%' .$spacer .$t12 .': ' .$server_uptime, 2, 1.06);
drawtext($banner, $text_custom, $color1, $font, $w, $h, $custom, 2, 2);
drawline($banner, 3.3, $color1, $font, $w, $h, date('H:i'), 1.21, 2.5, $line_thickness);
drawtext($banner, 3.3, $color1, $font, $w, $h, date('H:i'), 1.21, 2.5);
drawtext($banner, 1, $color1, $font, $w, $h, $date, 1.21, 1.8);
drawtext($banner, 1, $color1, $font, $w, $h, strftime('%A'), 1.21, 1.62);
drawtext($banner, 0.6, $color2, $font, $w, $h, $t13, 1.21, 6);
drawtext($banner, 1, $color2, $font, $w, $h, $last_user, 1.21, 4.6);
drawtext($banner, 0.6, $color2, $font, $w, $h, $last_time .' min', 1.21, 3.7);
if (!empty($version)) {
	imagefilledpolygon($banner, [$w*89, 0, $width, $h*23, $width, 0], 3, $color3);
	imagettftext($banner, $w*1 + $h*1, -37, $w*94.6, $h*5.6, $color2, $font, $server_version);
}

// Draw client info
if ($connected) {
	imagettftext($banner, $w*1.2 + $h*1.2, 0, $w*2, $h*15, $color2, $font, $t1);
	imagettftext($banner, $w*1 + $h*1, 0, $w*2, $h*25, $color2, $font, $t3 .': ' .$upload);
	imagettftext($banner, $w*1 + $h*1, 0, $w*2, $h*31, $color2, $font, $t4 .': ' .$download);
	imagettftext($banner, $w*1.2 + $h*1.2, 0, $w*2, $h*50, $color2, $font, $t2);
	imagettftext($banner, $w*1 + $h*1, 0, $w*2, $h*60, $color2, $font, $t5 .': ' .$client);
	$connected_hours >= 1
		? imagettftext($banner, $w*1 + $h*1, 0, $w*2, $h*66, $color2, $font, $t6 .': ' .$connected_hours.' h ' .$connected_min .' min')
		: imagettftext($banner, $w*1 + $h*1, 0, $w*2, $h*66, $color2, $font, $t6 .': ' .$connected_min .' min');
	imagettftext($banner, $w*1 + $h*1, 0, $w*2, $h*72, $color2, $font, $t7 .': ' .$total_connections);
	$flag = imagecreatefrompng('flags/' .$country .'.png');
	$flag = imagescale($flag, 90, 60, IMG_BICUBIC);
	imagefilledellipse($banner, $w*100 / 1.21 - 90 / 2 + 45, $h*100 / 1.45 + 60 / 2 + 30, 165, 165, $color3);
	imagecopy($banner, $flag, $w*100 / 1.21 - 90 / 2, $h*100 / 1.45 + 60 / 2, 0, 0, 90, 60);
	if (!empty($groups) && sizeof($server_group) > 0) {
		imagettftext($banner, $w*1 + $h*1, 0, $w*2, $h*78, $color2, $font, $t8 .': ');
		for ($i = 0, $x_groups = $w*$gpl; $i < $max_groups; $i++, $x_groups += 65) {
			for ($j = 0; $j < sizeof($bad_groups); $j++) {
				if ($server_group[$i] == $bad_groups[$j]) {
					array_splice($server_group, $i, 1);
				}
			}
			$group = imagecreatefrompng('server_groups/'.$server_group[$i].'.png');
			$group = imagescale($group, 60, 60, IMG_BICUBIC);
			imagecopy($banner,$group, $x_groups, $h*73.5, 0, 0, 60, 60);
		}
		if (sizeof($server_group) > $max_groups) {
			imagettftext($banner, $w*1 + $h*1, 0, $x_groups + 10, $h*78, $color2, $font, '...');
		}
	}
}
else {
	// Client connection problem
	imagettftext($banner, $w*1.2 + $h*1.2, 0, $w*2, $h*40, $color2, $font, $t14);
	imagettftext($banner, $w*1 + $h*1, 0, $w*2, $h*50, $color2, $font, $t15 .' ' .$server_name);
}

// Return the image
header('Content-type: image/png');
imagepng($banner);
imagedestroy($banner, $flag, $bg_image, $group);

?>
