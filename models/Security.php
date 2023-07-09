<?php

class Security
{
//####################################################################
    public $Registrar;
//####################################################################
    // Constructor

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;
    }

//####################################################################
    // CCCorrect checks whether the incoming CC in $_POST matches that displayed in the image. $Captcha->IsCCCorrect( $_POST['CaptchaCode'] )

    public function IsCCCorrect( $inCC )
    {
        $CCCorrect = 0;
        $CCLookupFile = $this->Registrar->Get('Config')->CCDir . '/CCLookupFile.txt';
        $Handle = fopen( $CCLookupFile, "r" );
        flock( $Handle, LOCK_SH );
        $LineBuffer = "";
        $CCs = array();
        if( $Handle )
        {
            while( ! feof( $Handle ) )                                         // Loop until end of file.
            {
                $LineBuffer = fgets( $Handle, 4096 );                          // Read a line.
                $LineBuffer = str_replace( "\n", "", $LineBuffer );
                $LineBuffer = str_replace( "\r", "", $LineBuffer );
                $LineElements = preg_split( "/ /", $LineBuffer );
                $key = $LineElements[0];
                $CCs[$key] = $LineElements[1];
            }
            fclose( $Handle );
        }

        if( isset( $inCC ) && empty( $inCC ) )
        {
            $inCC = "asdf";
        }

        if( array_key_exists( $inCC, $CCs ) )
        {
            $CCCorrect = 1;
            unlink( "{$CCs[$_POST['CaptchaCode']]}.png" );
        }

        return $CCCorrect;
    }

//####################################################################
    // Decrypt

    public function Decrypt( $inCipherText )
    {
        $CipherText = base64_decode( $inCipherText );
        $MessageText = '';
        $CertsKeysDir = $this->Registrar->Get('Config')->CertsKeysDir;
		$PrivateKeyFile = $this->Registrar->Get('Config')->PrivateKeyFile;
//        $PrivateKey = openssl_pkey_get_private( "file://{$CertsKeysDir}/buttonpw-prvkey.pem" );
        $PrivateKey = openssl_pkey_get_private( "file://{$CertsKeysDir}/{$PrivateKeyFile}" );
        openssl_private_decrypt( $CipherText, $MessageText, $PrivateKey );
        openssl_free_key( $PrivateKey );

        return $MessageText;

    }

//####################################################################
    // Encrypt

    public function Encrypt( $inMessageText )
    {
        $CipherText = '';
        $CertsKeysDir = $this->Registrar->Get('Config')->CertsKeysDir;
		$PublicKeyFile = $this->Registrar->Get('Config')->PublicKeyFile;
//        $PublicKey = openssl_pkey_get_public( "file://{$CertsKeysDir}/buttonpw-pubcert.pem" );
        $PublicKey = openssl_pkey_get_public( "file://{$CertsKeysDir}/{$PublicKeyFile}" );
        openssl_public_encrypt( $inMessageText, $CipherText, $PublicKey );
        openssl_free_key( $PublicKey );
        $CipherText = base64_encode( $CipherText );

        return $CipherText;
    }

//####################################################################
    // GenerateUniquePassword builds a random string to be used as a password, encrypts it, then checks to see wether the password already exists in the database. If so, then it builds a fresh string, checks it, and so on until a unique password is generated.

    public function GenerateUniquePassword( $inConnection )
    {
//----------------------------------------
        $EncryptedPasswords = mysqli_query( $inConnection,
                                            "SELECT password
                                             FROM staff_member");
        $CharacterPool = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $NewPassword = "";
        $EncryptedPassword = "";
        while( $NewPassword == "" )
        {
            for( $i = 0; $i < 10; $i++ )
            {
                $NewPassword = $NewPassword . substr( $CharacterPool, rand( 0, 61 ), 1 );
            }
            $EncryptedPassword = crypt( $NewPassword );
            while( $row = mysqli_fetch_array( $EncryptedPasswords ) )
            {
                if( $row['encrypted_password'] == $EncryptedPassword )
                {
                    $NewPassword = "";
                    break;
                }
            }
        }
        return $NewPassword;
    }

//####################################################################
    // FilterArray checks the elements of inArrayToBeFiltered, and places the ones that match inPatternString into inArrayToFill.

    public function FilterArray( $inArrayToBeFiltered, &$inArrayToFill, $inPatternString )
    {
        $Count = 0;
        foreach( $inArrayToBeFiltered as $Element )
        {
            if( preg_match( $inPatternString, $Element ) )
            {
                $inArrayToFill[$Count] = $Element;
                $Count = $Count + 1;
            }
        }
    }

//####################################################################
    // VerifyUser checks the password that the user supplied, and fills some inout variables with various user details.

    public function VerifyUser( $inUserDetailsTable, $inPassword, &$inPasswordVerified, &$inCustomerNumber, &$inEmailAddress )
    {
        while( $row = mysqli_fetch_array( $inUserDetailsTable ) )
        {
            if( crypt( $inPassword, $row['encrypted_password'] ) == $row['encrypted_password'] )
            {
                $inPasswordVerified = 1;
                $inCustomerNumber = $row['customer_number'];
                $inEmailAddress = $row['email_address'];
                break;
            }
        }
        mysqli_data_seek( $inUserDetailsTable, 0 );
    }

//####################################################################
}
?>
