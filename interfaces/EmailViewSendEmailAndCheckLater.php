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
        $EmailFrom = 'davidmortimer@topspek.com';

        if( $inRegistrar->Get('SendEmailAndCheckLater') )
        {
            $CustomerDetails = array();
            $CustomerDetails = $this->Registrar->Get('CustomerDetails');
            //$EmailTo = $CustomerDetails['email_address'];
            $EmailTo = 'davidmortimer@topspek.com';
            $OneCustomersStatementArray = array();
            $OneCustomersStatementArray = $this->Registrar->Get('OneCustomersStatement');
            $EmailSubject = 'Reminder: Invoices on the ' . $OneCustomersStatementArray[6] . '/' . $OneCustomersStatementArray[5] . ' statement are due for payment soon';
            $EmailMessage = 'To ' . $CustomerDetails['company_name'] . ".<br /><br />";

            $DaysOverdue = round( ( strtotime( date('Y-m-d') ) - strtotime( $OneCustomersStatementArray[4] ) ) / ( 60 * 60 * 24 ) );
            if( $DaysOverdue > 0 )
            {
                $EmailSubject = 'Reminder: Invoices on the ' . $OneCustomersStatementArray[6] . '/' . $OneCustomersStatementArray[5] . ' statement are ' . $DaysOverdue . ' days overdue';
                $EmailMessage .= 'This is a reminder that the invoices on statement ' . $OneCustomersStatementArray[6] . '/' . $OneCustomersStatementArray[5] . ' are now overdue by ' . $DaysOverdue . ' days.' . "<br /><br />";
            }
            else
            {
                $EmailMessage .= 'This is a reminder that the invoices on statement ' . $OneCustomersStatementArray[6] . '/' . $OneCustomersStatementArray[5] . ' with Kustom Design Printing Ltd are due for payment in ' . abs( $DaysOverdue ) . ' days.' . "<br /><br />";
            }

            $EmailMessage .= 'Company: ' . $CustomerDetails['company_name'] . "<br />";
            $EmailMessage .= 'Contact name: ' . $CustomerDetails['contact_name'] . "<br />";
            $EmailMessage .= 'Statement ID: ' . $OneCustomersStatementArray[6] . '/' . $OneCustomersStatementArray[5] . "<br />";
            $EmailMessage .= 'Due date: ' . $OneCustomersStatementArray[4] . "<br /><br />";

            $EmailMessage .= "Invoices<br />";
            $EmailMessage .= '<table border="1">';
            $EmailMessage .= "<tr><td>Date</td><td>Invoice ID</td><td>Amount outstanding</td></tr>";
            $TotalAmountOutstanding = 0.00;
            foreach( $this->Registrar->Get('StatementInvoices') as $StatementInvoice )
            {
                $EmailMessage .= '<tr><td>' . $StatementInvoice['creation_date'] . '</td><td>' . $StatementInvoice['invoice_number'] . '</td><td>£' . $StatementInvoice['amount_outstanding'] . '</td></tr>';
                $TotalAmountOutstanding += $StatementInvoice['amount_outstanding'];
            }
            $EmailMessage .= '<tr><td colspan="2">Total due on ' . $OneCustomersStatementArray[4] . '</td><td>£' . $TotalAmountOutstanding . '</td></tr>';
            $EmailMessage .= '</table><br /><br />';

            $EmailMessage .= "When you are ready to pay, you can pay by bank transfer.<br /><br />";
            //$EmailMessage .= "Sort code: ######<br />";
            //$EmailMessage .= "Account number: ########<br /><br />";
            //$EmailMessage .= "Please use your STATEMENT ID as the bank transfer reference if making a batch payment. If you’re paying invoices individually, please use the INVOICE ID as the bank transfer reference for each payment.<br />";
            //$EmailMessage .= "Alternatively, please call ######## where we can take debit or credit card payment by phone.<br /><br />";
            //$EmailMessage .= "IMPORTANT NOTE: Please make sure that all of the details, including the bank transfer details, match up with those on the statement we sent to you. If they don\'t, do not send payment. Contact us on ########## instead.<br /><br />";
            $EmailMessage .= "Thank you for your custom.<br />";

            $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
            $Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
        }
	}
}




























































?>
