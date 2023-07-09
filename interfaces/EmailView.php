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
        $EmailTo = "davidmortimer@ukappcoder.com";

        $EmailSubject = "Enquiry from ukappcoder.com";

        if( $inRegistrar->Get('MessageSend') )
        {
            $EmailMessage = "Sender details:\n\n";

            //$Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href", "\r", "\n" );
            $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );

            $EmailMessage .= "Email: " . str_replace( $Unwanted, "", $inRegistrar->Get( 'EmailAddress' ) ) . "\n";
            $EmailMessage .= "Name: " . str_replace( $Unwanted, "", $inRegistrar->Get( 'Name' ) ) . "\n_________________\n";
            $EmailMessage .= "\n\n" . str_replace( $Unwanted, "", $inRegistrar->Get( 'Message' ) ) . "\n";    

            $Headers = 'From: ' . $inRegistrar->Get( 'EmailAddress' ) . "\r\n" . 'Reply-To: ' . $inRegistrar->Get( 'EmailAddress' ) . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
        }
    }
}





















































?>
