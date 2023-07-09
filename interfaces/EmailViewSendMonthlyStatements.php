<?php

class EmailViewSendMonthlyStatements extends View
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
                $CustomerDetails = array();
                $CustomerDetails = $CustomerAndStatement['customer_details'];
                $EmailFrom = 'admin@kdpcredit.co.uk';
                $EmailTo = $CustomerDetails['email_address'] . ", " .
                           $CustomerDetails['email_address_2'] . ", " .
                           $CustomerDetails['email_address_3'] . ", " .
                           $CustomerDetails['email_address_4'];
                $EmailSubject = '';
                $EmailMessage = '';

                if( $this->Registrar->Get('PaymentDueAtEndOfMonth') )
                {
                    $EmailSubject .= 'KDP - Credit statement for ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'];
                    $EmailMessage .= 'To ' . $CustomerDetails['company_name'] . ".<br /><br />";
                }
                else
                {
                    if( $this->Registrar->Get('PaymentDueInThreeDays') )
                    {
                        $EmailSubject .= 'KDP - Credit statement for ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'];
                        $EmailMessage .= 'This is a reminder that the invoices on statement ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'];
                        $EmailMessage .= ' with Kustom Design Printing Ltd are due for payment in ' . abs( $CustomerAndStatement['days_until_due'] ) . ' days.' . "<br /><br />";
                    }
                    else
                    {
                        if( $this->Registrar->Get('PaymentOverdueByFourDays') )
                        {
                            $EmailSubject .= 'Reminder: Invoices on the ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . ' statement are ' . $DaysOverdue . ' days overdue';
                            $EmailMessage .= 'This is a reminder that the invoices on statement ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'];
                            $EmailMessage .= ' with Kustom Design Printing Ltd are now overdue by ' . $CustomerAndStatement['days_overdue'] . ' days.' . "<br /><br />";
                        }
                    }
                }

                //===================================================================================
                $EmailMessage .= 'Company: ' . $CustomerDetails['company_name'] . "<br />";
                $EmailMessage .= 'Contact name: ' . $CustomerDetails['contact_name'] . "<br />";
                $EmailMessage .= 'Statement ID: ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . "<br />";
                $EmailMessage .= 'Due date: ' . $CustomerAndStatement['due_date'] . "<br /><br />";

                $EmailMessage .= "Invoices<br />";
                $EmailMessage .= '<table border="1">';
                $EmailMessage .= "<tr><td>Date</td><td>Invoice ID</td><td>Amount outstanding</td></tr>";
                $TotalAmountOutstanding = 0.00;
                foreach( $CustomerAndStatement['statement_invoices'] as $StatementInvoice )
                {
                    $EmailMessage .= '<tr><td>' . $StatementInvoice['creation_date'] . '</td><td>' . $StatementInvoice['invoice_number'] . '</td><td>£' . $StatementInvoice['amount_outstanding'] . '</td></tr>';
                    $TotalAmountOutstanding += $StatementInvoice['amount_outstanding'];
                }
                $EmailMessage .= '<tr><td colspan="2">Total due on ' . $CustomerAndStatement['due_date'] . '</td><td>£' . $TotalAmountOutstanding . '</td></tr>';
                $EmailMessage .= '</table><br /><br />';

                $EmailMessage .= "Please click on the following link to download a PDF copy of your statement:<br /><br />";
                //$EmailMessage .= $this->Registrar->Get('Config')->CreditControlAppURL . "/pdf_invoices/" . $CustomerDetails['customer_id'] . "_PdfViewSendMonthlyStatement.pdf<br /><br />";
                $EmailMessage .= '<a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . "/pdf_invoices/" . $CustomerDetails['customer_id'] . '-' . $CustomerAndStatement['statement_year'] . '-' . $CustomerAndStatement['statement_month'] . '_PdfViewSendMonthlyStatement.pdf">DOWNLOAD PDF</a><br /><br />';

                $EmailMessage .= "When you are ready to pay, you can pay by bank transfer:<br /><br />";
                $EmailMessage .= "Sort code: ######<br />";
                $EmailMessage .= "Account number: ########<br /><br />";
                $EmailMessage .= "Please use your STATEMENT ID as the bank transfer reference if making a batch payment. If you’re paying invoices individually, please use the INVOICE ID as the bank transfer reference for each payment.<br />";
                $EmailMessage .= "Alternatively, please call ######## where we can take debit or credit card payment by phone.\r\n\r\n";
                $EmailMessage .= "IMPORTANT NOTE: Please make sure that all of the details, including the bank transfer details, match up with those on the statement we sent to you. If they don't, do not send payment. Contact us on ########## instead.<br /><br />";
                $EmailMessage .= "Thank you for your custom.<br />";
                //===================================================================================

                $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
                $Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
                mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
            }
        }
	}
}

























































?>
