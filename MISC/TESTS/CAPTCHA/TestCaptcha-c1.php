<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>Testing Captcha</title>
</head>

<body>

<?php
//===================================================================================
include "Config.php";
include '/var/www/www.topspek.com/models/Captcha.php';
$Captcha = new Captcha( $Registrar );
$CCCorrect = $Captcha->IsCCCorrect( $_POST['CaptchaCode'] );

$CCPngName = $Captcha->CreateCCPngName();
$CCPngFile = "{$CCPngName}.png";
$CC = $Captcha->CreateCC();
$Captcha->StoreCCImgFilePair( $CC, $CCPngName );

$image = $Captcha->warped_text_image( $Captcha->imgwid, $Captcha->imghgt, $CC );             // Create a warped image which includes our CC.
//add_text( $image, $signature );                                          // Optionally add a signature - e.g. your website's URL.
imagepng( $image, "{$CCPngName}.png" );                                    // Write the image to the .png image file. This is the image which will be displayed with the form.
//chmod( "{$CCPngName}.png", 0604 );
imagedestroy( $image );                                                    // Destroy the image to free up the memory.

//===================================================================================
echo $CCCorrect .
     '<br /><img src="http://www.topspek.com/MISC/TESTS/CAPTCHA/' . $CCPngName . '.png" /><br /><br />
      <form action="http://www.topspek.com/MISC/TESTS/CAPTCHA/TestCaptcha.php" method="post">
      <input type="textbox" name="CaptchaCode" />
      <input type="submit" name="Submit" value="Submit" />
      </form>';

//#############################################################################
//#############################################################################
//#############################################################################
//  $CCCorrect = 0;
//  $CCFile = "CCLookupFile.txt";
//  $Handle = fopen( $CCFile, "r" );
//  flock( $Handle, LOCK_SH );
//  $LineBuffer = "";
//  $CCs = array();
//  if( $Handle )
//  {
//    while( ! feof( $Handle ) )                                         // Loop until end of file.
//    {
//      $LineBuffer = fgets( $Handle, 4096 );                            // Read a line.
//      $LineBuffer = str_replace( "\n", "", $LineBuffer );
//      $LineBuffer = str_replace( "\r", "", $LineBuffer );
//      $LineElements = preg_split( "/ /", $LineBuffer );
//      $key = $LineElements[0];
//      $CCs[$key] = $LineElements[1];
//    }
//    fclose( $Handle );
//  }
//#############################################################################
//  if( isset( $_POST['CaptchaCode'] ) && empty( $_POST['CaptchaCode'] ) )
//  {
//    $_POST['CaptchaCode'] = "asdf";
//  }
//
//  if( array_key_exists( $_POST['CaptchaCode'], $CCs ) )
//  {
//    $CCCorrect = 1;
//    unlink( "{$CCs[$_POST['CaptchaCode']]}.png" );
//  }
//#############################################################################
// remember, the captcha code and image file name cannot be the same otherwise all the hacker would need to do scrape the file name from the HTML source...so if a hacker were to try this, then captcha code would be wrong...
// GenerateCcImgFilePair generates a unique captcha code (CC) and a unique name for the .png image file, and writes the CC and .png image file association to a lookup file...

//  $Letters = "ABDEFHKLMNOPRSTUVWXZ";
//
//  $CCFile = "CaptchaCodeFile.txt";                // the lookup file...
//  chmod( $CCFile, 0755 );
//  $CCPngFile = "";                                // the png image file...
//  $Handle = fopen( $CCFile, "a" );
//  flock( $Handle, LOCK_EX );
//  if( $Handle )
//  {
//    $PngFileExists = 1;                        // assume the png image file already exists...
//    while( $PngFileExists )
//    {
//      $CCPngName = "";                         // this will be the bare file name without the path or extension - e.g. 'XHDJR'...
//      for( $i = 0; $i < 5; ++$i )              // create the bare file name...
//      {
//        $CCPngName .= substr( $Letters, rand( 0, strlen( $Letters ) - 1 ), 1 );
//      }
//      $CCPngFile = "{$CCPngName}.png";
//      if( ! file_exists( $CCPngFile ) )                    // check that the bare file name we just created doesn't already exist...if not, the current loop will terminate...
//      {
//        $PngFileExists = 0;
//      }
//    }
//
//    $CC = "";
//    for( $i = 0; $i < 5; ++$i )         // create the captcha code
//    {
//      $CC .= substr( $Letters, rand( 0, strlen( $Letters ) - 1 ), 1 );
//    }
//
//    fwrite( $Handle, "{$CC} {$CCPngName}\n" );
//  }
//  fclose( $Handle );
//#############################################################################

?>

</body>
</html>
