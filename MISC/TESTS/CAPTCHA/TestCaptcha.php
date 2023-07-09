<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>Testing Captcha</title>
</head>

<body>

<?php
//#############################################################################
// controller

include "Config.php";
include $Registrar->Get('Config')->ModelsDir . '/Captcha.php';
$Captcha = new Captcha( $Registrar );

$CCCorrect = $Captcha->IsCCCorrect( $_POST['CaptchaCode'] );
$CCPngName = $Captcha->CreateCCPngName();
$CCPngFile = $Registrar->Get('Config')->CCDir . '/' . $CCPngName . '.png';
$CC = $Captcha->CreateCC();
$Captcha->StoreCCImgFilePair( $CC, $CCPngName );
$image = $Captcha->warped_text_image( $Captcha->imgwid, $Captcha->imghgt, $CC );             // Create a warped image which includes our CC.
$Captcha->add_text( $image, $Captcha->signature );                                           // Optionally add a signature - e.g. your website's URL.
imagepng( $image, $CCPngFile );                                                      // Write the image to the .png image file. This is the image which will be displayed with the form.
//chmod( "{$CCPngName}.png", 0604 );
imagedestroy( $image );                                                                      // Destroy the image to free up the memory.

$Registrar->Save( $CCPngName, 'CCPngName' );

//=============================================================================
echo $CCCorrect .
     '<br /><img src="' . $Registrar->Get('Config')->RootURL . '/resources/captcha/' . $Registrar->Get('CCPngName') . '.png" /><br /><br />
      <form action="' . $Registrar->Get('Config')->RootURL . '/MISC/TESTS/CAPTCHA/TestCaptcha.php" method="post">
      <input type="textbox" name="CaptchaCode" />
      <input type="submit" name="Submit" value="Submit" />
      </form>';

//#############################################################################
?>
</body>
</html>
