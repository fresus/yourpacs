<?php
session_start();

$captchaCode = substr(sha1(microtime() * mktime()), 0, 6);
$_SESSION['captcha'] = $captchaCode;

// Genero la imagen
$img = imagecreatetruecolor(70, 20);

// Colores
$bgColor     = imagecolorallocate($img, 221, 222, 229);
$stringColor = imagecolorallocate($img, 130, 139, 134);
$lineColor   = imagecolorallocate($img, 132, 194, 229);

// Fondo
imagefill($img, 0, 0, $bgColor);

imageline($img, 0, 5, 70, 5, $lineColor);
imageline($img, 0, 10, 70, 10, $lineColor);
imageline($img, 0, 15, 70, 15, $lineColor);
imageline($img, 0, 20, 70, 20, $lineColor);
imageline($img, 12, 0, 12, 25, $lineColor);
imageline($img, 24, 0, 24, 25, $lineColor);
imageline($img, 36, 0, 36, 25, $lineColor);
imageline($img, 48, 0, 48, 25, $lineColor);
imageline($img, 60, 0, 60, 25, $lineColor);


// Escribo el codigo
imageString($img, 5, 8, 3, $captchaCode, $stringColor);


// Image output.
header("Content-type: image/png");
imagepng($img);

?>
