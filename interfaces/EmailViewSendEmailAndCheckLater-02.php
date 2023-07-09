<?php

class EmailViewSendEmailAndCheckLater extends View
{
    public $Registrar;

	public function __construct( $inRegistrar )
	{
        $this->Registrar = $inRegistrar;
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
        $EmailTo = "davidmortimer@topspek.com";

        $EmailSubject = "Enquiry from topspek.com";

        if( $inRegistrar->Get('SendEmailAndCheckLater') )
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
