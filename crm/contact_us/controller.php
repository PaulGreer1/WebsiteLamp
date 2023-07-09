<?php
//======================================================================
include "Config.php";
//======================================================================
// VIEWS

include $Registrar->Get('Config')->InterfacesDir . '/View.php';

include $Registrar->Get('Config')->InterfacesDir . '/PageView.php';
$Title = 'Contact Topspek Software Systems for bespoke and ready-made PHP and MySQL software';
$PageView = new PageView( $Registrar, $Title );
$Registrar->Register( $PageView, 'GenerateView' );

include $Registrar->Get('Config')->InterfacesDir . '/EmailView.php';
$EmailView = new EmailView( $Registrar );
$Registrar->Register( $EmailView, 'GenerateView' );

//======================================================================
// MODELS

$ModelsDir = $Registrar->Get('Config')->ModelsDir;

//----------------------------------------------------------------------
// ADBANNER

include $ModelsDir . '/AdBanner.php';
$AdBanner = new AdBanner( $Registrar );
$Registrar->Save( $AdBanner->AdBanner(), 'AdBanner' );

//----------------------------------------------------------------------
// CAPTCHA

include $ModelsDir . '/Captcha.php';
$Captcha = new Captcha( $Registrar );

//======================================================================

if( isset( $_POST['SendMessage'] ) && $_POST['SendMessage'] )
{
    $ErrorMessage = '';
    $MessageSend = 0;

    if( ! $Captcha->IsCCCorrect( $_POST['CaptchaCode'] ) )
    {
        $ErrorMessage .= 'Error: Incorrect image code<br />';
    }

    if( ! preg_match( $Registrar->Get('Config')->EmailAddressPattern, $_POST['EmailAddress'] ) )
    {
            $ErrorMessage .= 'Error: Invalid email address<br />';
    }

    if( strlen( $_POST['Message'] ) == 0 )
    {
            $ErrorMessage .= 'Error: You forgot to write your message<br />';
    }

    if( strlen( $ErrorMessage ) == 0 )
    {
        $MessageSend = 1;
        $Registrar->Save( $_POST['EmailAddress'], 'EmailAddress' );
        $Registrar->Save( $_POST['Name'], 'Name' );
        $Registrar->Save( $_POST['Message'], 'Message' );
    }

    $Registrar->Save( $ErrorMessage, 'ErrorMessage' );
    $Registrar->Save( $MessageSend, 'MessageSend' );
}

$CCPngName = $Captcha->CreateCCPngName();
$CCPngFile = $Registrar->Get('Config')->CCDir . '/' . $CCPngName . '.png';
$CC = $Captcha->CreateCC();
$Captcha->StoreCCImgFilePair( $CC, $CCPngName );
$image = $Captcha->warped_text_image( $Captcha->imgwid, $Captcha->imghgt, $CC );     // Create a warped image which includes our CC.
$Captcha->add_text( $image, $Captcha->signature );                                   // Optionally add a signature - e.g. your website's URL.
imagepng( $image, $CCPngFile );                                                      // Write the image to the .png image file. This is the image
//chmod( "{$CCPngName}.png", 0604 );                                                 // which will be displayed with the form.
imagedestroy( $image );                                                              // Destroy the image to free up the memory.
$Registrar->Save( $CCPngName, 'CCPngName' );

//======================================================================
$Registrar->Notify();
//======================================================================
?>
