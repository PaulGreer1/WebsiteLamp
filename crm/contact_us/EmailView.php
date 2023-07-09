<?php

class EmailView extends View
{
    public function __construct( $inRegistrar )
    {
        $Interfaces = array();
        $ExtraInterfaces = array();
        foreach( $ExtraInterfaces as $ExtraInterface )
        {
            array_push( $Interfaces, $ExtraInterface );
        }
        parent::__construct( $inRegistrar, $Interfaces );
    }

    public function GenerateView( $inRegistrar )
    {
//        $EmailTo = "enquiries@topspek.com";                                            // EDIT THESE 2 LINES AS REQUIRED
//        $EmailTo = "support@topspek.com";
        $EmailTo = "davidmortimer@topspek.com";
//        $EmailTo = "davidreed4075@gmail.com";

        $EmailSubject = "Enquiry from topspek.com";

        if( $inRegistrar->Get( 'MessageSend' ) )
        {
            $EmailMessage = "Sender details:\n\n";

            $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );

            $EmailMessage .= "Email: " . str_replace( $Unwanted, "", $inRegistrar->Get( 'EmailAddress' ) ) . "\n";
            $EmailMessage .= "Name: " . str_replace( $Unwanted, "", $inRegistrar->Get( 'Name' ) ) . "\n_________________\n";
            $EmailMessage .= "\n\n" . str_replace( $Unwanted, "", $inRegistrar->Get( 'Message' ) ) . "\n";

            $Headers = 'From: ' . $inRegistrar->Get( 'EmailAddress' ) . "\r\n" . 'Reply-To: ' . $inRegistrar->Get( 'EmailAddress' ) . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
        }
    }
}



































/***********************************
NOTE: Headers must be defined!

I created a script to test the mail() function, and this works fine. I'm sure the problem with the other script is as you suggested - the 'From' header is not defined. I thought it was defined because I'm using a variable which is defined in another script. So I looked at the other script, but it is not being defined.

TEST:
------------------------------------
$To = "davidreed4075@gmail.com";

$Subject = "TESTING EMAIL FROM TOPSPEK";

$Message = "Testing email from topspek";

$Headers = "From: davidmortimer4075@gmail.com" . "\r\n" . 
           "CC: paulgreer6957@gmail.com";

mail( $To, $Subject, $Message, $Headers );

***********************************/
//======================================================================
//ini_set( 'display_errors', 1 );
//    error_reporting( E_ALL );
//    $from = "emailtest@YOURDOMAIN";
//    $to = "davidmortimer4075@gmail.com";
//    $subject = "PHP Mail Test script";
//    $message = "This is a test to check the PHP Mail functionality";
//    $headers = "From:" . $from;
//    mail($to,$subject,$message, $headers);
//    echo "Test email sent";
//======================================================================
?>
