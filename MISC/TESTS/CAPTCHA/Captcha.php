<?php
//##################################################################################
// <https://www.topspek.com/MISC/TESTS/CAPTCHA/Captcha.php
// CONFIG
//------------------------------------------------
// The server's path to the root public directory:

$DocRootDir = "/var/www/www.mortime.co.uk";                                     // Local     ***************************
//$DocRootDir = "/home/mortimec/public_html";                                     // WHB       ***************************

//##################################################################################
$font = "DejaVuSerif-Bold.ttf";
$signature = "www.mortime.co.uk";

$perturbation = 0.5;                                                            // bigger numbers give more distortion; 1 is standard
$imgwid = 200;                                                                  // image width, pixels
$imghgt = 100;                                                                  // image height, pixels
$numcirc = 4;                                                                   // number of wobbly circles
$numlines = 3;                                                                  // number of lines
$ncols = 20;                                                                    // foreground or background cols

//##################################################################################
// Usage

function CreateCCImage()
{
//$CC = $argv[1];
$image = warped_text_image( $imgwid, $imghgt, $CC );
add_text( $image, $signature );
//
//// Write the image to a file.
//
//$CCPngName = $argv[2];
imagepng( $image, "{$DocRootDir}/LABS/GD/CAPTCHA/{$CCPngName}.png" );
chmod( "{$DocRootDir}/LABS/GD/CAPTCHA/{$CCPngName}.png", 0777 );
//
//// Destroy the image to free up the memory.
//
imagedestroy( $image );
}

//##################################################################################
//##################################################################################
//##################################################################################
//##################################################################################
//##################################################################################
//##################################################################################
// Functions.

function frand()
{
  return 0.0001*rand(0,9999);
}

//==================================================================================
// Wiggly random line centered at specified coordinates.

function randomline($img, $col, $x, $y)
{
  $theta = (frand()-0.5)*M_PI*0.7;
  global $imgwid;
  $len = rand($imgwid*0.4,$imgwid*0.7);
  $lwid = rand(0,2);

  $k = frand()*0.6+0.2; $k = $k*$k*0.5;
  $phi = frand()*6.28;
  $step = 0.5;
  $dx = $step*cos($theta);
  $dy = $step*sin($theta);
  $n = $len/$step;
  $amp = 1.5*frand()/($k+5.0/$len);
  $x0 = $x - 0.5*$len*cos($theta);
  $y0 = $y - 0.5*$len*sin($theta);

  $ldx = round(-$dy*$lwid);
  $ldy = round($dx*$lwid);
  for ($i = 0; $i < $n; ++$i) {
    $x = $x0+$i*$dx + $amp*$dy*sin($k*$i*$step+$phi);
    $y = $y0+$i*$dy - $amp*$dx*sin($k*$i*$step+$phi);
    imagefilledrectangle($img, $x, $y, $x+$lwid, $y+$lwid, $col);
  }
}

//==================================================================================
// amp = amplitude (<1), num=numwobb (<1)
function imagewobblecircle($img, $xc, $yc, $r, $wid, $amp, $num, $col)
{
  $dphi = 1;
  if ($r > 0)
    $dphi = 1/(6.28*$r);
  $woffs = rand(0,100)*0.06283;
  for ($phi = 0; $phi < 6.3; $phi += $dphi) {
    $r1 = $r * (1-$amp*(0.5+0.5*sin($phi*$num+$woffs)));
    $x = $xc + $r1*cos($phi);
    $y = $yc + $r1*sin($phi);
    imagefilledrectangle($img, $x, $y, $x+$wid, $y+$wid, $col);
  }
}

//==================================================================================
// make a distorted copy from $tmpimg to $img. $wid, $height apply to $img,
// $tmpimg is a factor $iscale bigger.
function distorted_copy($tmpimg, $img, $width, $height, $iscale)
{
  $numpoles = 3;

  // make an array of poles AKA attractor points
  global $perturbation;
  for ($i = 0; $i < $numpoles; ++$i) {
    do {
      $px[$i] = rand(0, $width);
    } while ($px[$i] >= $width*0.3 && $px[$i] <= $width*0.7);
    do {
      $py[$i] = rand(0, $height);
    } while ($py[$i] >= $height*0.3 && $py[$i] <= $height*0.7);
    $rad[$i] = rand($width*0.4, $width*0.8);
    $tmp = -frand()*0.15-0.15;
    $amp[$i] = $perturbation * $tmp;
  }

  // get img properties bgcolor
  $bgcol = imagecolorat($tmpimg, 1, 1);
  $width2 = $iscale*$width;
  $height2 = $iscale*$height;
  
  // loop over $img pixels, take pixels from $tmpimg with distortion field
  for ($ix = 0; $ix < $width; ++$ix)
    for ($iy = 0; $iy < $height; ++$iy) {
      $x = $ix;
      $y = $iy;
      for ($i = 0; $i < $numpoles; ++$i) {
	$dx = $ix - $px[$i];
	$dy = $iy - $py[$i];
	if ($dx == 0 && $dy == 0)
	  continue;
	$r = sqrt($dx*$dx + $dy*$dy);
	if ($r > $rad[$i])
	  continue;
	$rscale = $amp[$i] * sin(3.14*$r/$rad[$i]);
	$x += $dx*$rscale;
	$y += $dy*$rscale;
      }
      $c = $bgcol;
      $x *= $iscale;
      $y *= $iscale;
      if ($x >= 0 && $x < $width2 && $y >= 0 && $y < $height2)
	$c = imagecolorat($tmpimg, $x, $y);
      imagesetpixel($img, $ix, $iy, $c);
    }
}

//==================================================================================
// add grid for debugging purposes
function addgrid($tmpimg, $width2, $height2, $iscale, $color) {
  $lwid = floor($iscale*3/2);
  imagesetthickness($tmpimg, $lwid);
  for ($x = 4; $x < $width2-$lwid; $x+=$lwid*2)
    imageline($tmpimg, $x, 0, $x, $height2-1, $color);
  for ($y = 4; $y < $height2-$lwid; $y+=$lwid*2)
    imageline($tmpimg, 0, $y, $width2-1, $y, $color);
}

//==================================================================================
function warped_text_image($width, $height, $string)
{
  // internal variablesinternal scale factor for antialias
  $iscale = 3;

  // initialize temporary image
  $width2 = $iscale*$width;
  $height2 = $iscale*$height;
  $tmpimg = imagecreate($width2, $height2);
  $bgColor = imagecolorallocatealpha ($tmpimg, 192, 192, 192, 100);
  $col = imagecolorallocate($tmpimg, 0, 0, 0);

  // init final image
  $img = imagecreate($width, $height);
  imagepalettecopy($img, $tmpimg);    
  imagecopy($img, $tmpimg, 0,0 ,0,0, $width, $height);
  
  // put straight text into $tmpimage
  global $font;
  $fsize = $height2*0.25;
  $bb = imageftbbox($fsize, 0, $font, $string);
  $tx = $bb[4]-$bb[0];
  $ty = $bb[5]-$bb[1];
  $x = floor($width2/2 - $tx/2 - $bb[0]);
  $y = round($height2/2 - $ty/2 - $bb[1]);
  imagettftext($tmpimg, $fsize, 0, $x, $y, -$col, $font, $string);

  // addgrid($tmpimg, $width2, $height2, $iscale, $col); // debug

  // warp text from $tmpimg into $img
  distorted_copy($tmpimg, $img, $width, $height, $iscale);

  // add wobbly circles (spaced)
  global $numcirc;
  for ($i = 0; $i < $numcirc; ++$i) {
    $x = $width * (1+$i) / ($numcirc+1);
    $x += (0.5-frand())*$width/$numcirc;
    $y = rand($height*0.1, $height*0.9);
    $r = frand();
    $r = ($r*$r+0.2)*$height*0.2;
    $lwid = rand(0,2);
    $wobnum = rand(1,4);
    $wobamp = frand()*$height*0.01/($wobnum+1);
    imagewobblecircle($img, $x, $y, $r, $lwid, $wobamp, $wobnum, $col);
  }
  
  // add wiggly lines
  global $numlines;
  for ($i = 0; $i < $numlines; ++$i) {
    $x = $width * (1+$i) / ($numlines+1);
    $x += (0.5-frand())*$width/$numlines;
    $y = rand($height*0.1, $height*0.9);
    randomline($img, $col, $x, $y);
  }

  return $img;
}

//==================================================================================
function add_text($img, $string)
{
  $cmtcol = imagecolorallocatealpha ($img, 128, 0, 0, 64);
  imagestring($img, 5, 10, imagesy($img)-20, $string, $cmtcol);
}

//##################################################################################
/***************************************

 Han-Kwang Nienhuys' PHP captcha
 Copyright June 2007

 This copyright message and attribution must be preserved upon
 modification. Redistribution under other licenses is expressly allowed.
 Other licenses include GPL 2 or higher, BSD, and non-free licenses.
 The original, unrestricted version can be obtained from
 http://www.lagom.nl/linux/hkcaptcha/ .
 
 **************************************
 
 Yet another captcha implementation in PHP.  This one is written with
 the current state (as of 2007) of captcha-defeating research in
 mind. Apart from a letter distortion that is more advanced than just
 rotating the letters, the clutter is designed to make segmentation of
 the image into separate letter glyphs hard to do automatically.

 The 5-letter code is stored into the PHP session variable
 $_SESSION['captcha_string']; see the examples example.html and verify.php.
 
***************************************/
//##################################################################################
?>

