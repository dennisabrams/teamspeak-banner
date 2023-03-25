<?php

/*
 * Drawing functions for ts3-banner.php
 *
 * Author: Dennis Abrams
 * Repository: https://github.com/dennisabrams/teamspeak3-banner
 *
 */

function drawtext($banner, $t_size, $color1, $font, $w, $h, $text, $x, $y) {
	$t_size = $w*$t_size + $h*$t_size;
	$t_box = imagettfbbox($t_size, 0, $font, $text);
	$t_width = abs($t_box[2]) - abs($t_box[0]);
	$t_height = abs($t_box[5]) - abs($t_box[3]);
	imagettftext($banner, $t_size, 0, $w*100 / $x - $t_width / 2, $h*100 / $y + $t_height / 2, $color1, $font, $text);
}

function drawline($banner, $t_size, $color1, $font, $w, $h, $text, $x, $y, $line_thickness) {
	$t_size = $w*$t_size + $h*$t_size;
	$t_box = imagettfbbox($t_size, 0, $font, $text);
	$t_width = abs($t_box[2]) - abs($t_box[0]);
	imagefilledrectangle($banner, $w*100 / $x - $t_width / 2 + 10, $h*(50 - $line_thickness), ($w*100 / $x - $t_width / 2) + $t_width, $h*(50 + $line_thickness), $color1);
}

function drawimg($banner, $width, $height, $imgpath, $img_size) {
	$img = imagecreatefromstring(file_get_contents($imgpath));
	list($img_width, $img_height) = getimagesize($imgpath);
	$img_reswidth = $img_width / 100 * $img_size;
	$img_resheight = $img_height / 100 * $img_size;
	$img = imagescale($img, $img_reswidth, $img_resheight, IMG_BICUBIC);
	imagecopy($banner, $img, $width / 2 - $img_reswidth / 2, $height / 2 - $img_resheight / 2, 0, 0, $img_reswidth, $img_resheight);
}

?>