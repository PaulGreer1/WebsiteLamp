<?php
//======================================================================
include "Config.php";
//======================================================================
// SEMAPHORE

$LockFileHandle = fopen( $Registrar->Get('Config')->SemaphoreLockFile, "w" );
flock( $LockFileHandle, LOCK_EX );

//======================================================================
// VIEWS

include $Registrar->Get('Config')->InterfacesDir . '/View.php';

include $Registrar->Get('Config')->InterfacesDir . '/PageView.php';
$Title = 'TopSpek Software Systems login or register';
$PageView = new PageView( $Registrar, $Title );
$Registrar->Register( $PageView, 'GenerateView' );

include $Registrar->Get('Config')->InterfacesDir . '/EmailViewResetPasswordRegister.php';
$EmailViewResetPasswordRegister = new EmailViewResetPasswordRegister( $Registrar );
$Registrar->Register( $EmailViewResetPasswordRegister, 'GenerateView' );

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

//include $ModelsDir . '/StaffMember.php';
$Member = new StaffMember( $Registrar );

include $ModelsDir . '/Company.php';
$Company = new Company( $Registrar );

include $ModelsDir . '/CompanyStaffMember.php';
$CompanyMember = new CompanyStaffMember( $Registrar );

include $ModelsDir . '/Customer.php';
$Customer = new Customer( $Registrar );

//----------------------------------------------------------------------
// OTHERS

include $ModelsDir . '/Service.php';
$Service = new Service( $Registrar );

//----------------------------------------------------------------------
// CAPTCHA

include $ModelsDir . '/Captcha.php';
$Captcha = new Captcha( $Registrar );

//======================================================================
$DBConnection = $Registrar->Get('DBConnection');
//======================================================================
// START TRANSACTION

mysqli_begin_transaction( $DBConnection );

//======================================================================
$SendEmail = 0;
$ErrorMessage = '';

$CipherText = '';
$TAWelcomeMessage = '';
$Recipients = array();

$TaRegistered = 0;
$TsRegistered = 0;

$LogOut = 0;

if( $_POST['Register'] )
{
    if( $Captcha->IsCCCorrect( $_POST['CaptchaCode'] ) )
    {
        if( preg_match( $Registrar->Get('Config')->EmailAddressPattern, $_POST['EmailAddress'] ) &&
            preg_match( $Registrar->Get('Config')->AlphaNumericPattern, $_POST['MemberName'] ) &&
            preg_match( $Registrar->Get('Config')->AlphaNumericPattern, $_POST['CompanyName'] ) )
        {
            if( $_POST['CompanyName'] == $_POST['ConfirmCompanyName'] )
            {
                if( $_POST['StaffType'] == 'TaOfNewCo'  )
                {
                    if( ! $Service->Exists( $DBConnection, 'company', 'company_name', $_POST['CompanyName'] ) )
                    {
                        $CompanyId = $Service->GenerateLowestUniqueIdNumber( $Service->SQLTableToArray( $DBConnection, 'company', 'company_id' ) );
                        $MemberId = $Service->GenerateLowestUniqueIdNumber( $Service->SQLTableToArray( $DBConnection, 'staff_member', 'staff_id_number' ) );
                        $NewPassword = $Security->GenerateUniquePassword( $DBConnection );
                        $EncryptedPassword = crypt( $NewPassword );
                        $Company->Insert( $DBConnection, $CompanyId, $_POST['CompanyName'] );
                        $Member->Insert( $DBConnection, $MemberId, $_POST['MemberName'], $EncryptedPassword, $_POST['EmailAddress'], 'Admin', 1, '0011', 'pending' );
                        $CompanyMember->Insert( $DBConnection, $MemberId, $CompanyId );

                        $CipherText = $Security->Encrypt( $NewPassword );
                        //========================================================================

                        //************************************************************************
                        $NewDbStatusCode = $Security->GenerateUniquePassword( $DBConnection );                       // new DbStatusCode generated
                        $DbStatusCodeFile = $Registrar->DbStatusCodeDir . '/' . $CompanyId . '.txt';
                        file_put_contents( $DbStatusCodeFile, $NewDbStatusCode );                                    // new DbStatusCode written to the file (overwriting existing code if file already exists)
                        //************************************************************************
                        $QueryStringInputs = '';
                        $QueryStringInputs .= 'key=' . urlencode( $CipherText );
                        $QueryStringInputs .= '&amp;DbStatusCode=' . $NewDbStatusCode;
                        $Registrar->Save( $QueryStringInputs, 'QueryStringInputs' );
                        //************************************************************************
                        $HiddenFormFieldInputs = '';
                        $HiddenFormFieldInputs .= '<input type="hidden" name="key" value="' . $CipherText . ' />';
                        $HiddenFormFieldInputs .= '<input type="hidden" name="DbStatusCode" value="' . $NewDbStatusCode . ' />';
                        $Registrar->Save( $HiddenFormFieldInputs, 'HiddenFormFieldInputs' );
                        //************************************************************************

                        //========================================================================
                        $TaContentMessage = "A password and an activation link have been emailed to: " . $_POST['EmailAddress'];
                        //$TaEmailMessage = 'Please click on the link below to activate your new account at topspek.com:<br /><a href="http://www.topspek.com/crm/membership/controller.php>Activate</a>';
                        $TaEmailMessage = 'Please click on the link below to activate your new account at topspek.com:' . "\r\n\r\n" . 'http://www.topspek.com/crm/membership/controller.php' . "\r\n\r\n";
                        $TaEmailMessage .= 'Your password is: ' . $NewPassword . "\r\n\r\n";
                        $TaEmailMessage .= 'All the best from the TopSpek team';

                        $TaDetails = array( member_name => $_POST['MemberName'], email_address => $_POST['EmailAddress'], company_name => $_POST['CompanyName'], email_message => $TaEmailMessage );
                        array_push( $Recipients, $TaDetails );
                        //========================================================================

foreach( $Recipients as $Recipient )
{
//    echo $Recipient['member_name'] . '<br />' .  $Recipient['email_address'] . '<br />' . $Recipient['company_name'] . '<br />' . $NewPassword . '<br />' . $NewPassword . '<br />';
}
$Registrar->Save( $NewPassword, 'NewPassword' );

                        //========================================================================
                        //$Registrar->Save( $DbStatusCode, 'DbStatusCode' );
                        $Registrar->Save( $CipherText, 'Key' );
                        $Registrar->Save( $TaContentMessage, 'TaContentMessage' );
                        $Registrar->Save( $TaEmailMessage, 'TaEmailMessage' );
                        $Registrar->Save( $Recipients, 'Recipients' );

                        $TaRegistered = 1;
                        $Registrar->Save( $TaRegistered, 'TaRegistered' );
                        $SendEmail = 1;
                        $Registrar->Save( $SendEmail, 'SendEmail' );
                    }
                    else
                    {
                        $ErrorMessage = "Error: That company name already exists. Perhaps you intended to join an existing company as a team staff member.";
                    }
                }
                else
                {
                    if( $_POST['StaffType'] == 'TsOfExistingCo' )
                    {
                        if( $Service->Exists( $DBConnection, 'company', 'company_name', $_POST['CompanyName'] ) )
                        {
                            $CompanyDetails = array();
                            $CompanyDetails = $Company->GetCompanyDetailsByCompanyName( $DBConnection, $_POST['CompanyName'] );
                            if( ! $Member->EmailIsUniqueInTeam( $DBConnection, $CompanyDetails['company_id'], $_POST['EmailAddress'] ) )
                            {
//echo 'HI<br />';
                                $MemberId = $Service->GenerateLowestUniqueIdNumber( $Service->SQLTableToArray( $DBConnection, 'staff_member', 'staff_id_number' ) );
                                $NewPassword = $Security->GenerateUniquePassword( $DBConnection );
                                $EncryptedPassword = crypt( $NewPassword );
                                $Member->Insert( $DBConnection, $MemberId, $_POST['MemberName'], $EncryptedPassword, $_POST['EmailAddress'], 'Agent', 0, '0001', 'pending' );
                                $CompanyMember->Insert( $DBConnection, $MemberId, $CompanyDetails['company_id'] );

                                $CipherText = $Security->Encrypt( $NewPassword );
                                //========================================================================

                                //************************************************************************
                                $NewDbStatusCode = $Security->GenerateUniquePassword( $DBConnection );                             // new DbStatusCode generated
                                $DbStatusCodeFile = $Registrar->DbStatusCodeDir . '/' . $CompanyDetails['company_id'] . '.txt';
                                file_put_contents( $DbStatusCodeFile, $NewDbStatusCode );                                          // new DbStatusCode written to the file (overwriting existing code if file already exists)
                                //************************************************************************
                                $QueryStringInputs = '';
                                $QueryStringInputs .= 'key=' . urlencode( $CipherText );
                                $QueryStringInputs .= '&amp;DbStatusCode=' . $NewDbStatusCode;
                                $Registrar->Save( $QueryStringInputs, 'QueryStringInputs' );
                                //************************************************************************
                                $HiddenFormFieldInputs = '';
                                $HiddenFormFieldInputs .= '<input type="hidden" name="key" value="' . $CipherText . ' />';
                                $HiddenFormFieldInputs .= '<input type="hidden" name="DbStatusCode" value="' . $NewDbStatusCode . ' />';
                                $Registrar->Save( $HiddenFormFieldInputs, 'HiddenFormFieldInputs' );
                                //************************************************************************

                                //========================================================================
                                $TaEmailMessage = "A new member called " . $_POST['MemberName'] . " with email address: " . $_POST['EmailAddress'] . " is attempting to join your team. If you recognise this member, then you can activate the member by clicking the following link:" . "\r\n\r\n";
                                $TaEmailMessage .= 'http://www.topspek.com/crm/membership/controller.php';
                                $TsEmailMessage = "An activation link has been emailed to your team admin. We will notify you when your team admin has activated your account." . "\r\n\r\n";
                                $TsEmailMessage .= "Your password is: " . $NewPassword . ", but you won't be able to log in until your team admin has activated your account.";
                                $TsContentMessage = "An activation link has been emailed to your team admin. Once your team admin has activated your account, you will be automatically notified.";

                                $TaMemberDetails = $Member->GetTaByCompanyName( $DBConnection, $_POST['CompanyName'] );
                                $TaDetails = array( member_name => $TaMemberDetails['member_name'], email_address => $TaMemberDetails['email_address'], company_name => $TaMemberDetails['company_name'], email_message => $TaEmailMessage );
                                array_push( $Recipients, $TaDetails );
                                $TsDetails = array( member_name => $_POST['MemberName'], email_address => $_POST['EmailAddress'], company_name => $_POST['CompanyName'], email_message => $TsEmailMessage );
                                array_push( $Recipients, $TsDetails );
                                //========================================================================

foreach( $Recipients as $Recipient )
{
//    echo $Recipient['member_name'] . '<br />' .  $Recipient['email_address'] . '<br />' . $Recipient['company_name'] . '<br />' . $NewPassword . '<br />';
}
//echo $NewPassword . '<br />';
$Registrar->Save( $NewPassword, 'NewPassword' );

                                //========================================================================
                                $Registrar->Save( $CipherText, 'Key' );
                                $Registrar->Save( $TsContentMessage, 'TsContentMessage' );
                                $Registrar->Save( $TsEmailMessage, 'TsEmailMessage' );
                                $Registrar->Save( $Recipients, 'Recipients' );

                                $TsRegistered = 1;
                                $Registrar->Save( $TsRegistered, 'TsRegistered' );
                                $SendEmail = 1;
                                $Registrar->Save( $SendEmail, 'SendEmail' );
                            }
                            else
                            {
                                $ErrorMessage = "Error: Please provide another email address. There is already a member on this team with this email address.";
                            }
                        }
                        else
                        {
                            $ErrorMessage = "Error: No such company.";
                        }
                    }
                    else
                    {
                        if( ! $_POST['StaffType'] )
                        {
                            $ErrorMessage = "Error: Please choose which type of membership you want.";
                        }
                    }
                }
            }
            else
            {
                $ErrorMessage = "Error: Please ensure that the textboxes 'Company name' and 'Confirm company name' are the same.";
            }
        }
        else
        {
            $ErrorMessage = "Error: Please ensure that the textboxes 'Email address', 'Member name' and 'Company name' contain valid input.";
        }
    }
    else
    {
        $ErrorMessage = "Error: Please ensure that textbox 'Image code' contains the same letters as those in the image.";
    }
}
else
{
    if( $_POST['Login'] )
    {
        if( preg_match( $Registrar->Get('Config')->AlphaNumericPattern, $_POST['Password'] ) )
        {
            if( $Member->VerifyUser( $DBConnection, $Member->GetAllMembers( $DBConnection ), $_POST['Password'] ) )
            {
                $StaffMemberDetails = $Member->GetMemberDetails( $DBConnection, $_POST['Password'] );
                if( $StaffMemberDetails['is_active'] )
                {
                    $Registrar->Save( $StaffMemberDetails, 'StaffMemberDetails' );
                    $Registrar->Save( $StaffMemberDetails, 'GlobalStaffMemberDetails' );
                    $LoggedIn = 1;
                    $WelcomeMessage = 'Welcome back';
                    $CipherText = $Security->Encrypt( $_POST['Password'] );
                    //************************************************************************
                    $NewDbStatusCode = $Security->GenerateUniquePassword( $DBConnection );                                    // new DbStatusCode generated
                    $DbStatusCodeFile = $Registrar->DbStatusCodeDir . '/' . $StaffMemberDetails['company_id'] . '.txt';
                    file_put_contents( $DbStatusCodeFile, $NewDbStatusCode );                                                 // new DbStatusCode written to the file (overwriting existing code if file already exists)
                    //************************************************************************
                    $QueryStringInputs = '';
                    $QueryStringInputs .= 'key=' . urlencode( $CipherText );
                    $QueryStringInputs .= '&amp;DbStatusCode=' . $NewDbStatusCode;
                    $Registrar->Save( $QueryStringInputs, 'QueryStringInputs' );
                    //************************************************************************
                    $HiddenFormFieldInputs = '';
                    $HiddenFormFieldInputs .= '<input type="hidden" name="key" value="' . $CipherText . ' />';
                    $HiddenFormFieldInputs .= '<input type="hidden" name="DbStatusCode" value="' . $NewDbStatusCode . ' />';
                    $Registrar->Save( $HiddenFormFieldInputs, 'HiddenFormFieldInputs' );
                    //************************************************************************

                    $Registrar->Save( $CipherText, 'Key' );                        // This is placed on links or in hidden form fields so that it is used in Config.php to .. .
                    $Registrar->Save( $LoggedIn, 'LoggedIn' );
                }
                else
                {
                    $ErrorMessage = 'Sorry ' . $StaffMemberDetails['username'] . ', we cannot log you in right now because your account is currently inactive. Please contact your team leader.';
                }
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
//$Registrar->Save( $WelcomeMessage, 'WelcomeMessage' );
//$Registrar->Save( $Registered, 'Registered' );
$Registrar->Save( $LogOut, 'LogOut' );

if( strlen( $Registrar->Get( 'ErrorMessage' ) ) > 0 || $_GET['LogOut'] )
{
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
}

//mysqli_num_rows( $Company->GetCompany( $DBConnection, $_POST['CompanyName'] ) ) == 0
//======================================================================
/*
---------------------------------
end transaction...
---------------------------------
if( $DBStatusChanged ), then update the DBStatus file...if the database was changed during execution of the responders above, then the $DBStateHasChanged flag will have been set to true...
*/
//======================================================================
$Registrar->Notify();
//======================================================================
// COMMIT CHANGES TO DATABASE

mysqli_commit( $DBConnection );

//======================================================================
// RELEASE SEMAPHORE
flock( $LockFileHandle, LOCK_UN );
fclose( $LockFileHandle );
//======================================================================
?>
