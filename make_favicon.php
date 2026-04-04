<?php
$size = 32;
$img = imagecreatetruecolor($size, $size);
imagealphablending($img, false);
imagesavealpha($img, true);

$red   = imagecolorallocate($img, 209, 0, 36);
$white = imagecolorallocate($img, 255, 255, 255);
$trans = imagecolorallocatealpha($img, 0, 0, 0, 127);

// Fill transparent
imagefilledrectangle($img, 0, 0, $size-1, $size-1, $trans);

// Rounded red square (simulate with circles on corners)
imagefilledrectangle($img, 4, 0, 27, 31, $red);
imagefilledrectangle($img, 0, 4, 31, 27, $red);
imagefilledellipse($img, 4, 4, 8, 8, $red);
imagefilledellipse($img, 27, 4, 8, 8, $red);
imagefilledellipse($img, 4, 27, 8, 8, $red);
imagefilledellipse($img, 27, 27, 8, 8, $red);

// Letter N (bold)
imagesetthickness($img, 3);
imageline($img, 9, 7, 9, 24, $white);
imageline($img, 9, 7, 22, 24, $white);
imageline($img, 22, 7, 22, 24, $white);

imagepng($img, __DIR__ . '/public/favicon-32.png');
imagedestroy($img);
echo "PNG created\n";
