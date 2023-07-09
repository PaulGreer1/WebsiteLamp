<?php
//======================================================================
include "Config.php";
//======================================================================
// VIEWS

include $Registrar->Get('Config')->InterfacesDir . '/View.php';

include $Registrar->Get('Config')->InterfacesDir . '/PageView.php';
$Title = 'Login or register';
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
// ENTITIES

include $ModelsDir . '/Member.php';
$Member = new Member( $Registrar );

include $ModelsDir . '/Company.php';
$Company = new Company( $Registrar );

include $ModelsDir . '/CompanyMember.php';
$CompanyMember = new CompanyMember( $Registrar );

include $ModelsDir . '/PrivilegeMember.php';
$PrivilegeMember = new PrivilegeMember( $Registrar );

//----------------------------------------------------------------------
// OTHERS

include $ModelsDir . '/Service.php';
$Service = new Service( $Registrar );

//----------------------------------------------------------------------
// CAPTCHA

include $ModelsDir . '/Captcha.php';
$Captcha = new Captcha( $Registrar );

//======================================================================
// acquire semaphore...

$LockFileHandle = fopen( $Registrar->Get('Config')->SemaphoreLockFile, "r" );
flock( $LockFileHandle, LOCK_EX );

//======================================================================
// dbstatus code...
//======================================================================
// check whether responders can be executed...if( $PasswordVerified && $DBStatusOk )...
//======================================================================
// start transaction
//======================================================================    t8GRzxk1vT
$ErrorMessage = '';
$WelcomeMessage = '';
$LoggedIn = 0;
$Registered = 0;
$LogOut = 0;
$CipherText = '';
$DBConnection = $Registrar->Get('DBConnection');

if( $_POST['Login'] )
{
    if( preg_match( $Registrar->Get('Config')->AlphaNumericPattern, $_POST['Password'] ) )
    {
        if( $Member->VerifyUser( $DBConnection, $Member->GetAllMembers( $DBConnection ), $_POST['Password'] ) )
        {
            $LoggedIn = 1;
            $WelcomeMessage = 'Welcome back';
            $CipherText = $Security->Encrypt( $_POST['Password'] );
            $Registrar->Save( $CipherText, 'Key' );                        // This is placed on links or in hidden form fields so that it is used in Config.php to .. .
            $Registrar->Save( $LoggedIn, 'LoggedIn' );
        }
        else
        {
            $ErrorMessage = 'Error: No such member.';
        }
    }
    else
    {
        $ErrorMessage = 'Error: Invalid password.';
    }
}
else
{
    if( $_POST['Register'] )
    {
        if( $Captcha->IsCCCorrect( $_POST['CaptchaCode'] ) )
        {
            if( ! $Service->Exists( $DBConnection, 'member', 'email_address', $_POST['EmailAddress'] ) )
            {
                if( preg_match( $Registrar->Get('Config')->EmailAddressPattern, $_POST['EmailAddress'] ) &&
                    preg_match( $Registrar->Get('Config')->AlphaNumericPattern, $_POST['MemberName'] ) &&
                    preg_match( $Registrar->Get('Config')->AlphaNumericPattern, $_POST['CompanyName'] ) )
                {
                    if( mysqli_num_rows( $Company->GetCompany( $DBConnection, $_POST['CompanyName'] ) ) == 0 )
                    {
                        $NewPassword = $Security->GenerateUniquePassword( $DBConnection );
                        $EncryptedPassword = crypt( $NewPassword );
                        $MemberId = $Service->GenerateLowestUniqueIdNumber( $Service->SQLTableToArray( $DBConnection, 'member', 'member_id' ) );

                        $Company->Insert( $DBConnection, $_POST['CompanyName'] );
                        $Member->Insert( $DBConnection, $MemberId, $_POST['MemberName'], $EncryptedPassword, $_POST['EmailAddress'] );
                        $CompanyMember->Insert( $DBConnection, $MemberId, $_POST['CompanyName'] );
                        $PrivilegeMember->Insert( $DBConnection, $MemberId, 'VOUCH' );

                        $Registered = 1;
                        $LoggedIn = 1;
                        $WelcomeMessage = 'Welcome. Your password is: ' . $NewPassword;      // BFqqKzgFy1
                        $CipherText = $Security->Encrypt( $NewPassword );

                        $Registrar->Save( $CipherText, 'Key' );
                        $Registrar->Save( $LoggedIn, 'LoggedIn' );
                    }
                    else
                    {
                        $ErrorMessage = 'Error: This company already has a team admin.';
                    }
                }
                else
                {
                    $ErrorMessage = 'Error: Please ensure that your email address, name and company name are valid.';
                }
            }
            else
            {
                $ErrorMessage = 'Error: This email address is already in use.';
            }
        }
        else
        {
            $ErrorMessage = 'Error: Captcha code does not match.';
        }
    }
    else
    {
        if( $_GET['LogOut'] )
        {
            $WelcomeMessage = 'You are logged out.';
            $LoggedIn = 0;
            $LogOut = 1;
        }
        else // This request is for a new login/register form.
        {
            $CCPngName = $Captcha->CreateCCPngName();
            $CCPngFile = $Registrar->Get('Config')->CCDir . '/' . $CCPngName . '.png';
            $CC = $Captcha->CreateCC();
            $Captcha->StoreCCImgFilePair( $CC, $CCPngName );
            $image = $Captcha->warped_text_image( $Captcha->imgwid, $Captcha->imghgt, $CC );
            $Captcha->add_text( $image, $Captcha->signature );
            imagepng( $image, $CCPngFile );
            //chmod( "{$CCPngName}.png", 0604 );
            imagedestroy( $image );
            $Registrar->Save( $CCPngName, 'CCPngName' );
        }
    }
}

$Registrar->Save( $ErrorMessage, 'ErrorMessage' );
$Registrar->Save( $WelcomeMessage, 'WelcomeMessage' );
$Registrar->Save( $Registered, 'Registered' );
$Registrar->Save( $LogOut, 'LogOut' );

if( strlen( $Registrar->Get( 'ErrorMessage' ) ) > 0 )
{
    $CCPngName = $Captcha->CreateCCPngName();
    $CCPngFile = $Registrar->Get('Config')->CCDir . '/' . $CCPngName . '.png';
    $CC = $Captcha->CreateCC();
    $Captcha->StoreCCImgFilePair( $CC, $CCPngName );
    $image = $Captcha->warped_text_image( $Captcha->imgwid, $Captcha->imghgt, $CC );     // Create a warped image which includes our CC.
    $Captcha->add_text( $image, $Captcha->signature );                                   // Optionally add a signature - e.g. your website's URL.
    imagepng( $image, $CCPngFile );                                                      // Write the image to the .png image file. This is the image which will be displayed with the form.
    //chmod( "{$CCPngName}.png", 0604 );
    imagedestroy( $image );                                                              // Destroy the image to free up the memory.
    $Registrar->Save( $CCPngName, 'CCPngName' );
}

//======================================================================
/*
---------------------------------
end transaction...
---------------------------------
if( $DBStatusChanged ), then update the DBStatus file...if the database was changed during execution of the responders above, then the $DBStateHasChanged flag will have been set to true...
*/
//======================================================================
// release semaphore...
flock( $LockFileHandle, LOCK_UN );
fclose( $LockFileHandle );
//======================================================================
$Registrar->Notify();
//======================================================================
?>
