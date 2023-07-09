<?php

class EmailViewStatementFullyPaid extends View
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
        if( $this->Registrar->Get('MessageSend') )
        {
            foreach( $this->Registrar->Get('CustomersAndStatements') as $CustomerAndStatement )
            {
                $EmailFrom = 'admin@kdpcredit.co.uk';
                $EmailTo = $CustomerAndStatement['customer_details']['email_address'] . ", " .
                           $CustomerAndStatement['customer_details']['email_address_2'] . ", " .
                           $CustomerAndStatement['customer_details']['email_address_3'] . ", " .
                           $CustomerAndStatement['customer_details']['email_address_4'];
                $EmailSubject = 'KDP - Credit statement for ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'];

                $EmailMessage = '';
                $EmailMessage .= 'This is a receipt of payments received for your invoices due in statement ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'];
                $EmailMessage .= ' with Kustom Design Printing Ltd.' . "<br /><br />";

                $EmailMessage .= 'Statement ID: ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . "<br />";
                
                $EmailMessage .= "Payments received<br />";
                $EmailMessage .= '<table border="1">';
                $EmailMessage .= "<tr><td>Amount paid</td><td>Transaction ID</td></tr>";
                foreach( $CustomerAndStatement['statement_payment_transactions'] as $StatementPaymentTransactions )
                {
                    foreach( $StatementPaymentTransactions as $StatementPaymentTransaction )
                    {
                        $EmailMessage .= '<tr><td>' . $StatementPaymentTransaction['amount_paid'] . '</td><td>' . $StatementPaymentTransaction['payment_transaction_number'] . '</td></tr>';
                    }
                }
                $EmailMessage .= "</table><br />";

                $StatementInitialAmount = 0.00;
                foreach( $CustomerAndStatement['statement_invoices'] as $StatementInvoice )
                {
                    $StatementInitialAmount += $StatementInvoice['initial_amount'];
                }

                $EmailMessage .= "Statement original balance: £" . $StatementInitialAmount . "<br />";
                $EmailMessage .= "Total paid: £" . $CustomerAndStatement['statement_amount_paid'] . "<br />";
                $EmailMessage .= "Balance due for " . $CustomerAndStatement['statement_month'] . "/" . $CustomerAndStatement['statement_year'] . " statement: £0.00<br />";

                $EmailMessage .= "The available credit for " . $CustomerAndStatement['customer_details']['company_name'] . " is now £" . $CustomerAndStatement['available_credit'] . ".<br /><br />";
                $EmailMessage .= "For any new orders, or to quickly re-order a previous order, please call our dedicated line on ######## to speak to an account manager.<br /><br />";
                $EmailMessage .= "Thank you for your custom.<br /><br />";

                $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
                $Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
                mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
            }
        }
	}
}

































































?>
