<?php

class PdfView extends View
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
		if( $inRegistrar->Get( 'GeneratePdf' ) )
		{
            require( $inRegistrar->Get('Config')->FpdfDir . '/fpdf.php' );
            foreach( $inRegistrar->Get('CustomersAndStatements') as $CustomerAndStatement )
            {
                $CustomerDetails = array();
                $CustomerDetails = $CustomerAndStatement['customer_details'];
                $pdf = new FPDF();
                $pdf->AddPage();
                $Header = '';
                $Content1 = '';
                $Content2 = '';
                $pdf->SetFont( 'Arial', '', 12 );

                if( $inRegistrar->Get('PaymentDueAtEndOfMonth') )
                {
                    $pdf->Write( 5, 'KDP - Credit statement for ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . "\n\n" );
                    $pdf->Write( 5, 'To: ' . $CustomerDetails['company_name'] . "\n" );
                }
                else
                {
                    if( $inRegistrar->Get('PaymentDueInThreeDays') )
                    {
                        $pdf->Write( 5, 'KDP - Credit statement for ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . "\n" );
                        $pdf->Write( 5, 'This is a reminder that the invoices on statement ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . "\n" );
                        $pdf->Write( 5, ' with Kustom Design Printing Ltd are due for payment in ' . abs( $CustomerAndStatement['days_until_due'] ) . ' days.' . "\n" );
                    }
                    else
                    {
                        if( $inRegistrar->Get('PaymentOverdueByFourDays') )
                        {
                            $pdf->Write( 5, 'Reminder: Invoices on the ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . ' statement are ' . $DaysOverdue . ' days overdue' . "\n" );
                            $pdf->Write( 5, 'This is a reminder that the invoices on statement ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . "\n" );
                            $pdf->Write( 5, ' with Kustom Design Printing Ltd are now overdue by ' . $CustomerAndStatement['days_overdue'] . ' days.' . "\n" );
                        }
                    }
                }

                //===================================================================================
                $pdf->Write( 5, 'Company: ' . $CustomerDetails['company_name'] . "\n" );
                $pdf->Write( 5, 'Contact name: ' . $CustomerDetails['contact_name'] . "\n" );
                $pdf->Write( 5, 'Statement ID: ' . $CustomerAndStatement['statement_year'] . '/' . $CustomerAndStatement['statement_month'] . "\n" );
                $pdf->Write( 5, 'Due date: ' . $CustomerAndStatement['due_date'] . "\n\n" );

                $pdf->Write( 5, "Invoices\n\n" );
                //$pdf->Write( 5, "Date | Invoice ID | Amount outstanding\n\n" );
                $TotalAmountOutstanding = 0.00;
                foreach( $CustomerAndStatement['statement_invoices'] as $StatementInvoice )
                {
                    $pdf->Write( 5, "Date: " . $StatementInvoice['creation_date'] . "\nInvoice ID: " . $StatementInvoice['invoice_number'] . "\nAmount outstanding: " . $StatementInvoice['amount_outstanding'] . "\n\n" );
                    $TotalAmountOutstanding += $StatementInvoice['amount_outstanding'];
                }
                $pdf->Write( 5, 'Total due on ' . $CustomerAndStatement['due_date'] . ': ' . $TotalAmountOutstanding . "\n\n" );

                $pdf->Write( 5, "When you are ready to pay, you can pay by bank transfer:\n\n" );
                $pdf->Write( 5, "Sort code: ######\n" );
                $pdf->Write( 5, "Account number: ########\n\n" );
                $pdf->Write( 5, "Please use your STATEMENT ID as the bank transfer reference if making a batch payment. If you are paying invoices individually, please use the INVOICE ID as the bank transfer reference for each payment.\n\n" );
                $pdf->Write( 5, "Alternatively, please call ######## where we can take debit or credit card payment by phone.\n\n" );
                $pdf->Write( 5, "IMPORTANT NOTE: Please make sure that all of the details, including the bank transfer details, match up with those on the statement we sent to you. If they don't, do not send payment. Contact us on ########## instead.\n\n" );
                $pdf->Write( 5, "Thank you for your custom.\n" );
                //===================================================================================

                echo 'DONE<br />';
                //$OutputFile = $inRegistrar->Get('Config')->PdfInvoicesDir . '/PdfViewSendMonthlyStatement.pdf';
                $OutputFile = $inRegistrar->Get('Config')->PdfInvoicesDir . '/' . $CustomerDetails['customer_id'] . '-' . $CustomerAndStatement['statement_year'] . '-' . $CustomerAndStatement['statement_month'] . '_PdfViewSendMonthlyStatement.pdf';
                $pdf->Output( F, $OutputFile );
            }
        }
    }
}

// Cell( float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link ] ] ] ] ] ] ] )































































?>
