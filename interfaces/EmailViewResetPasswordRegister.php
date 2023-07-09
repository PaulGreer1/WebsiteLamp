<?php

class EmailViewResetPasswordRegister extends View
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
        if( $this->Registrar->Get('SendEmail') )
        {
            $EmailFrom = 'admin@topspek.com';

            if( $this->Registrar->Get( 'TaRegistered' ) )
            {
                foreach( $this->Registrar->Get('Recipients') as $Recipient )
                {
                    $EmailTo .= $Recipient['email_address'];
                    $EmailSubject = 'Please activate your new account at topspek.com';
                    $EmailMessage = $Recipient['email_message'];

                    $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
                    $Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
                    mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
                }
            }
            else
            {
                if( $this->Registrar->Get( 'TsRegistered' ) )
                {
                    foreach( $this->Registrar->Get('Recipients') as $Recipient )
                    {
                        $EmailTo = $Recipient['email_address'];
                        $EmailSubject = 'New account at topspek.com';
                        $EmailMessage = $Recipient['email_message'];

                        $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
                        $Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
                        mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
                    }
                }
            }
        }
	}
}

/***********************************************************************************
    public function GenerateView( $inRegistrar )
    {
        $EmailFrom = 'support@topspek.com';
        //=========================================================================
        if( $this->Registrar->Get('MessageSendToAdmins4Days') )
        {
            $EmailTo = '';
            foreach( $this->Registrar->Get('StaffMembers') as $StaffMember )
            {
                $EmailTo .= $StaffMember['email_address'] . ", ";
            }
            $EmailSubject = 'Credit accounts which have not yet ordered';

            $EmailMessage = "The following accounts were created 4 days ago but have yet to place an order. Automated reminder emails will be sent to these customers tomorrow.\r\n";
            foreach( $this->Registrar->Get('FourDayCustomers') as $FourDayCustomer )
            {
                $EmailMessage .= 'ID: ' . $FourDayCustomer['customer_id'] . "\r\n" .
                                 'Company: ' . $FourDayCustomer['company_name'] . "\r\n" .
                                 'Contact name: ' . $FourDayCustomer['contact_name'] . "\r\n" .
                                 'Phone: ' . $FourDayCustomer['phone_number'] . "\r\n" .
                                 'Email: ' . $FourDayCustomer['email_address'] . "\r\n" .
                                 'Credit limit: ' . $FourDayCustomer['credit_limit'] . "\r\n" .
                                 "\r\n_________________\r\n";
            }

            $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
            $Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
        }
        //=========================================================================
	}
***********************************************************************************/

?>
