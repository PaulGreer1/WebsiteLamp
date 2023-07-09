<?php
//##################################################################
class Config
{
    public $Server = 'local';
//    public $Server = 'remote';

    public $DefaultInterfaces;
    public $EmailAddressPattern;
    public $AlphaNumericPattern;
    public $DocRootDir;
    public $ModelsDir;
    public $EntitiesDir;
    public $InterfacesDir;
    public $CertsKeysDir;
	public $PublicKeyFile;
	public $PrivateKeyFile;
    public $DbStatusCodeDir;
    public $SemaphoreLockFile;

    public $CCDir;
    public $FontsDir;

    public $RootURL;
    public $CreditControlAppURL;

    public $DBPrefix;
    public $DBHost;
    public $DBUsername;
    public $DBPassword;

    public $Database;
    
    public $ErrorMessage;
    public $MessageSend;

    public function __construct()
    {
        $this->DefaultInterfaces = array( 'Header.php', 'Topmenu.php', 'LeftPanel.php', 'Content.php', 'RightPanel.php', 'Footer.php' );
        $this->EmailAddressPattern = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
        $this->AlphaNumericPattern = '/^[A-Za-z0-9 ]+$/';
        if( $this->Server == 'local' )
        {
            $this->DocRootDir = '/var/www/www.local_ukappcoder.com';
            $this->ModelsDir = $this->DocRootDir . '/models';
            $this->EntitiesDir = $this->DocRootDir . '/models/entities';
            $this->InterfacesDir = $this->DocRootDir . '/interfaces';
            $this->CertsKeysDir = $this->DocRootDir . '/MISC/TESTS/Security/Encryption/Certificates_and_keys';
			$this->PublicKeyFile = 'public_key.pem';
			$this->PrivateKeyFile = 'private_key.pem';
            $this->DbStatusCodeDir = $this->DocRootDir . '/resources/misc_files';
            $this->SemaphoreLockFile = $this->DocRootDir . '/resources/misc_files/Semaphore.txt';

            $this->CCDir = $this->DocRootDir . '/resources/captcha';
            $this->FontsDir = $this->DocRootDir . '/resources/fonts';

            $this->RootURL = 'http://www.local_ukappcoder.com';
            $this->CreditControlAppURL = $this->RootURL . '/financial_tools/credit_control';

            $this->DBPrefix = '';
            $this->DBHost = 'localhost';
            $this->DBUsername = 'root';
            $this->DBPassword = '';

            $this->Database = 'LocalUkAppCoder';
            
            $this->ErrorMessage = '';
            $this->MessageSend = '';
        }
        else
        {
            $this->DocRootDir = '/home/topspekc/public_html';
            $this->ModelsDir = $this->DocRootDir . '/models';
            $this->EntitiesDir = $this->DocRootDir . '/models/entities';
            $this->InterfacesDir = $this->DocRootDir . '/interfaces';
            $this->CertsKeysDir = $this->DocRootDir . '/MISC/TESTS/Security/Encryption/Certificates_and_keys';
			$this->PublicKeyFile = 'public_key.pem';
			$this->PrivateKeyFile = 'private_key.pem';
            $this->DbStatusCodeDir = $this->DocRootDir . '/resources/misc_files';
            $this->SemaphoreLockFile = $this->DocRootDir . '/resources/misc_files/Semaphore.txt';

            $this->CCDir = $this->DocRootDir . '/resources/captcha';
            $this->FontsDir = $this->DocRootDir . '/resources/fonts';

            $this->RootURL = 'https://www.ukappcoder.com';
            $this->CreditControlAppURL = $this->RootURL . '/financial_tools/credit_control';

            $this->DBPrefix = '';
            $this->DBHost = 'localhost';
            $this->DBUsername = 'topspekc';
            $this->DBPassword = '9Dv6u[DZ#2wO8q';

            $this->Database = 'topspekc_Topspek';
            
            $this->ErrorMessage = '';
            $this->MessageSend = '';
        }
    }
}



//##################################################################

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//##################################################################
// SAVE CONFIGURATION TO THE REGISTRAR

$Config = new Config();
include $Config->ModelsDir . '/Registrar.php';
$Registrar = new Registrar();
$Registrar->Save( $Config, 'Config' );

//##################################################################
// DATABASE STUFF

$DBConnection = mysqli_connect( $Registrar->Get('Config')->DBHost, $Registrar->Get('Config')->DBUsername, $Registrar->Get('Config')->DBPassword );

if( ! $DBConnection )
{
    die( 'Connect Error: (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() );
}
$Registrar->Save( $DBConnection, 'DBConnection' );

//$Query = 'USE ' . $Registrar->Get('Config')->DBPrefix . 'BusinessSystem';
//$Query = 'USE ' . $Registrar->Get('Config')->DBPrefix . 'LocalKDPCredit';
//$Query = 'USE LocalKDPCredit';
$Query = 'USE ' . $Registrar->Get('Config')->Database;

if( ! mysqli_query( $DBConnection, $Query ) )
{
    echo mysqli_error( $DBConnection ) . '<br />';
}
//echo 'HI<br />';
//##################################################################
// MODELS

include $Registrar->Get('Config')->ModelsDir . '/Security.php';
$Security = new Security( $Registrar );

include $Registrar->Get('Config')->ModelsDir . '/StaffMember.php';
$GlobalStaffMember = new StaffMember( $Registrar );

include $Registrar->Get('Config')->ModelsDir . '/App.php';
$App = new App( $Registrar );

include $Registrar->Get('Config')->ModelsDir . '/Lease.php';
$Lease = new Lease( $Registrar );

//##################################################################
// LOGIN MAINTENANCE

// GET THE CIPHERTEXT FROM THE QUERY STRING OR FORM INPUT

$CipherText = '';
$MessageText = '';

if( isset( $_GET['key'] ) && $_GET['key'] !== '' )
{
    $CipherText = $_GET['key'];
}
else
{
    if( isset( $_POST['key'] ) && $_POST['key'] !== '' )
    {
        $CipherText = $_POST['key'];
    }
}

// GET THE USER'S PASSWORD FROM THE CIPHERTEXT, AND A NEW CIPHERTEXT FROM THE PASSWORD, AND SAVE THEM TO THE REGISTRAR

if( strlen( $CipherText ) > 0 )
{
    $MessageText = $Security->Decrypt( $CipherText );
    $CipherText = $Security->Encrypt( $MessageText );
}

$Registrar->Save( $MessageText, 'Password' );
$Registrar->Save( $CipherText, 'Key' );

//##################################################################
// RETRIEVE THE DATABASE STATUS CODE SENT FROM THE CLIENT AND SAVE IT TO THE REGISTRAR

$inDbStatusCode = '';
if( isset( $_GET['DbStatusCode'] ) && $_GET['DbStatusCode'] !== '' )
{
    $inDbStatusCode = $_GET['DbStatusCode'];
}
else
{
    if( isset( $_POST['DbStatusCode'] ) && $_POST['DbStatusCode'] !== '' )
    {
        $inDbStatusCode = $_POST['DbStatusCode'];
    }
}

$Registrar->Save( $inDbStatusCode, 'inDbStatusCode' );

//##################################################################
// IF THERE IS A SHOPPING CART STRING, THEN INCLUDE IT IN $QueryStringInputs and $HiddenFormFieldInputs.

$inShoppingCartString = '';
if( isset( $_GET['ShoppingCartString'] ) && $_GET['ShoppingCartString'] !== '' )
{
    $inShoppingCartString = $_GET['ShoppingCartString'];
}
else
{
    if( isset( $_POST['ShoppingCartString'] ) && $_POST['ShoppingCartString'] !== '' )
    {
        $inShoppingCartString = $_POST['ShoppingCartString'];
    }
}

$Registrar->Save( $inShoppingCartString, 'inShoppingCartString' );

//##################################################################
// IF THE PASSWORD SENT BY THE CLIENT IS THAT OF A REGISTERED MEMBER, THEN ..

$Verified = 0;
$LoggedIn = 0;
$DbStatusCodeFlag = 0;

$QueryStringInputs = '';
$Registrar->Save( $QueryStringInputs, 'QueryStringInputs' );
    
$HiddenFormFieldInputs = '';
$Registrar->Save( $HiddenFormFieldInputs, 'HiddenFormFieldInputs' );

$ErrorMessage = '';
$Registrar->Save( $ErrorMessage, 'ErrorMessage' );
$MessageSend = '';
$Registrar->Save( $MessageSend, 'MessageSend' );

if( preg_match( $Registrar->Get('Config')->AlphaNumericPattern, $Registrar->Get('Password') ) &&
    $GlobalStaffMember->VerifyUser( $DBConnection, $GlobalStaffMember->GetAllMembers( $DBConnection ), $Registrar->Get('Password') ) )
{
    $Verified = 1;
    //==================================================================
    // GET THE DETAILS OF THE STAFF MEMBER WHO SENT THE REQUEST

    $GlobalStaffMemberDetails = $GlobalStaffMember->GetMemberDetails( $DBConnection, $Registrar->Get('Password') );
    $Registrar->Save( $GlobalStaffMemberDetails, 'GlobalStaffMemberDetails' );
    $LoggedIn = 1;
    $Registrar->Save( $LoggedIn, 'LoggedIn' );

    //==================================================================
    // ENSURE THAT THE STAFF MEMBER'S COMPANY HAS A CURRENT LEASE ON THE APP AND THAT THE STAFF MEMBER IS AUTHORISED TO USE THE APP

    $RequestURI = $_SERVER['REQUEST_URI'];
    $ThisApp = substr( $RequestURI, 0, strrpos( $RequestURI, '/' ) );                // $ThisApp will be empty for the domain name - i.e. for topspek.com.
    if( $App->Exists( $DBConnection, 'app', 'app_path', $ThisApp ) )
    {
        if( ! $Lease->IsLeasing( $DBConnection, $GlobalStaffMemberDetails['company_id'], $ThisApp ) ||
            ! $App->IsAuthorised( $DBConnection, $GlobalStaffMemberDetails['staff_id_number'], $ThisApp ) )
        {
            $Verified = 0;
        }
    }

    //==================================================================
    // RETRIEVE THE DATABASE STATUS CODE CURRENTLY STORED ON THE SERVER AND SAVE IT TO THE REGISTRAR

    $DbStatusCodeFile = $Registrar->Get('Config')->DbStatusCodeDir . '/' . $GlobalStaffMemberDetails['company_id'] . '.txt';
    $DbStatusCode = file_get_contents( $DbStatusCodeFile );

    if( strcmp( $inDbStatusCode, $DbStatusCode ) == 0 )
    {
        $DbStatusCodeFlag = 1;
        $DbStatusCode = $Security->GenerateUniquePassword( $DBConnection );
        file_put_contents( $DbStatusCodeFile, $DbStatusCode );
    }

    //==================================================================
    // DEFINE SOME ARGUMENTS TO PLACE ON THE QUERY STRING AND/OR IN HIDDEN FORM FIELDS

    $QueryStringInputs .= 'key=' . urlencode( $Registrar->Get('Key') ) . '&amp;DbStatusCode=' . urlencode( $DbStatusCode );
    $Registrar->Save( $QueryStringInputs, 'QueryStringInputs' );

    $HiddenFormFieldInputs .= '<input type="hidden" name="key" value="' . $Registrar->Get('Key') . '" />' . '<input type="hidden" name="DbStatusCode" value="' . $DbStatusCode . '" />';
    $Registrar->Save( $HiddenFormFieldInputs, 'HiddenFormFieldInputs' );

    //==================================================================
}

//##################################################################
// (??? I CHANGED THE CREDIT SYSTEM SO THAT MY SITE WOULD ALLOW MANY COMPANIES, EACH WITH THEIR OWN TEAMS OF STAFF MEMBERS, .. ...THE OLD SYSTEM HAD A DATABASE TABLE CALLED member INSTEAD OF THE CURRENT staff_member TABLE...IN THE /../crm/membership/controller.php FILE, I AM STILL ASSIGNING THE VARIABLE $Member TO HOLD THE $StaffMember OBJECT...WE NEED TO CHANGE $Member TO $StaffMember THROUGHOUT THE CONTROLLER FILE... ???)
//------------------------------------------------------------------
// I STARTED TO TRANSFER THE ACQUISITION OF STAFF MEMBER DETAILS FROM THE CONTROLLER FILES TO THE CONFIG FILE BECAUSE THIS WAS BEING DONE IN EVERY CONTROLLER FILE...I DECIDED TO FACTOR THIS CODE OUT FROM THE CONTROLLERS TO THE CONFIG...WE CAN NOW DISPENSE WITH THE ACQUISITION OF STAFF MEMBER DETAILS IN THE CONTROLLERS, AND INSTEAD DO IT IN A SINGLE PLACE - THE CONFIG FILE... ???)
//------------------------------------------------------------------
// (??? THIS ALSO GOES FOR $QueryStringInputs AND $HiddenFormFieldInputs... ???)
//------------------------------------------------------------------
// (??? IN THE CONTROLLER FILES, WE CAN NOW REPLACE $StaffMember WITH $GlobalStaffMember. ???)
//------------------------------------------------------------------
// (??? IN THE /../crm/membership/controller.php FILE, WE CAN REPLACE $Member WITH $GlobalStaffMember... ???)
//##################################################################
?>
