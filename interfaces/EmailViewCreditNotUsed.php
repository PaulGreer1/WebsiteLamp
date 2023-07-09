<?php

class EmailViewCreditNotUsed extends View
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
        $EmailFrom = 'admin@kdpcredit.co.uk';
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

        if( $this->Registrar->Get('MessageSendToAdmins11Days') )
        {
            $EmailTo = '';
            foreach( $this->Registrar->Get('StaffMembers') as $StaffMember )
            {
                $EmailTo .= $StaffMember['email_address'] . ", ";
            }
            $EmailSubject = 'Credit accounts which have not yet ordered';

            $EmailMessage .= "The following accounts were created 11 days ago but have yet to place an order. Automated reminder emails will be sent to these customers tomorrow.\r\n";
            foreach( $this->Registrar->Get('ElevenDayCustomers') as $ElevenDayCustomer )
            {
                $EmailMessage .= 'ID: ' . $ElevenDayCustomer['customer_id'] . "\r\n" .
                                 'Company: ' . $ElevenDayCustomer['company_name'] . "\r\n" .
                                 'Contact name: ' . $ElevenDayCustomer['contact_name'] . "\r\n" .
                                 'Phone: ' . $ElevenDayCustomer['phone_number'] . "\r\n" .
                                 'Email: ' . $ElevenDayCustomer['email_address'] . "\r\n" .
                                 'Credit limit: ' . $ElevenDayCustomer['credit_limit'] . "\r\n" .
                                 "\r\n_________________\r\n";
            }

            $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
            $Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
        }

        //=========================================================================
        if( $this->Registrar->Get('MessageSendToCustomers5Days') )
        {
            foreach( $this->Registrar->Get('FiveDayCustomers') as $FiveDayCustomer )
            {
                $EmailTo = $FiveDayCustomer['email_address'];
                $EmailSubject = "Your credit account is awaiting an initial order";
                $EmailMessage = "Dear " . $FiveDayCustomer['contact_name'] . "\r\n\r\n";
                $EmailMessage .= "We have noticed that you were approved for a credit account with Kustom Design Printing Ltd 5 days ago, but have yet to place your first order on credit.\r\n";
                $EmailMessage .= "If you will be ordering at a later date, you can ignore this message. If you feel this has been sent in error, please contact us. We have included your account details below for your convenience:\r\n";
                $EmailMessage .= "Your initial credit limit is " . $FiveDayCustomer['credit_limit'] . " with a term limit of 30 days.\r\n";
                $EmailMessage .= "To finalise your order, please call ########## (Mon-Fri, 9am-5pm). Alternatively, you can contact us online.\r\n";
                $EmailMessage .= "When contacting us, please quote your credit account ID: " . $FiveDayCustomer['credit_account_number'] . ".\r\n";
                $EmailMessage .= "Thank you for choosing Kustom Design Printing Ltd.\r\n";

    			$Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
    			$Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    			mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
            }
        }

        if( $this->Registrar->Get('MessageSendToCustomers12Days') )
        {
            foreach( $this->Registrar->Get('TwelveDayCustomers') as $TwelveDayCustomer )
            {
                $EmailTo = $TwelveDayCustomer['email_address'];
                $EmailSubject = 'Your credit account is awaiting an initial order';
                $EmailMessage = "Dear " . $TwelveDayCustomer['contact_name'] . "\r\n\r\n";
                $EmailMessage .= "We have noticed that you were approved for a credit account with Kustom Design Printing Ltd 12 days ago, but have yet to place your first order on credit.\r\n";
                $EmailMessage .= "If you will be ordering at a later date, you can ignore this message. If you feel this has been sent in error, please contact us. We have included your account details below for your convenience:\r\n";
                $EmailMessage .= "Your initial credit limit is " . $TwelveDayCustomer['credit_limit'] . " with a term limit of 30 days.\r\n";
                $EmailMessage .= "To finalise your order, please call ########## (Mon-Fri, 9am-5pm). Alternatively, you can contact us online.\r\n";
                $EmailMessage .= "When contacting us, please quote your credit account ID: " . $TwelveDayCustomer['credit_account_number'] . ".\r\n";
                $EmailMessage .= "Thank you for choosing Kustom Design Printing Ltd.\r\n";

    			$Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
    			$Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    			mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
            }
        }
        //=========================================================================
	}
}

?>
