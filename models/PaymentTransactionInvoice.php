<?php
//####################################################################
// PaymentTransactionInvoice( PaymentTransactionNumber, InvoiceNumber )
//####################################################################
class PaymentTransactionInvoice
{
//####################################################################
    public $Registrar;
    public $Prefix;
//####################################################################
    // Constructor

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;
        $this->Prefix = $this->Registrar->Get('Config')->DBPrefix;
    }

//####################################################################
    // Insert.

    public function Insert( $inConnection, $inPaymentTransactionNumber, $inInvoiceNumber, $inAmountPaid, $inPaymentType )
    {
        $Sql = "INSERT INTO {$this->Prefix}payment_transaction_invoice( payment_transaction_number, invoice_number, amount_paid, payment_type )
                VALUES ( ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iids", $PaymentTransactionNumber, $InvoiceNumber, $AmountPaid, $PaymentType );

        $PaymentTransactionNumber = $inPaymentTransactionNumber;
        $InvoiceNumber = $inInvoiceNumber;
        $AmountPaid = $inAmountPaid;
        $PaymentType = $inPaymentType;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $Query = "INSERT INTO {$this->Prefix}payment_transaction_invoice( payment_transaction_number, invoice_number, amount_paid, payment_type )
                  VALUES ( '{$inPaymentTransactionNumber}', '{$inInvoiceNumber}', '{$inAmountPaid}', '{$inPaymentType}' )";

		mysqli_query( $inConnection, $Query ) or die( mysqli_error( $inConnection ) );
*********************************************************************/
    }

//####################################################################
	// DeletePaymentTransactionInvoice.

	public function DeletePaymentTransactionInvoice( $inConnection, $inPaymentTransactionNumber, $inInvoiceNumber )
	{
        $Sql = "DELETE
                FROM {$this->Prefix}payment_transaction_invoice
                WHERE payment_transaction_number = ? AND
                      invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $PaymentTransactionNumber, $InvoiceNumber );
        $PaymentTransactionNumber = $inPaymentTransactionNumber;
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
	}

//####################################################################
    // GetPaymentTransactionInvoiceDetails.

    public function GetPaymentTransactionInvoiceDetails( $inConnection, $inPaymentTransactionNumber, $inInvoiceNumber )
    {
        $Sql = "SELECT payment_transaction_number, invoice_number, amount_paid
                FROM {$this->Prefix}payment_transaction_invoice
                WHERE payment_transaction_number = ? AND
                      invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $PaymentTransactionNumber, $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;
        $PaymentTransactionNumber = $inPaymentTransactionNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rInvoiceNumber, $rAmountPaid );
        $PaymentTransactionInvoiceDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $rPaymentTransactionNumber;
            $PaymentTransactionInvoiceDetails['invoice_number'] = $rInvoiceNumber;
            $PaymentTransactionInvoiceDetails['amount_paid'] = $rAmountPaid;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentTransactionInvoiceDetailsTable = mysqli_query( $inConnection,
                                                               "SELECT payment_transaction_number, invoice_number, amount_paid
                                                                FROM {$this->Prefix}payment_transaction_invoice
                                                                WHERE payment_transaction_number = {$inPaymentTransactionNumber} AND
                                                                      invoice_number = {$inInvoiceNumber}" ) or die( mysqli_error( $inConnection ) );
        $PaymentTransactionInvoiceDetails = array();
        while( $Row = mysqli_fetch_assoc( $PaymentTransactionInvoiceDetailsTable ) )
        {
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $Row['payment_transaction_number'];
            $PaymentTransactionInvoiceDetails['invoice_number'] = $Row['invoice_number'];
            $PaymentTransactionInvoiceDetails['amount_paid'] = $Row['amount_paid'];
        }
        mysqli_data_seek( $PaymentTransactionInvoiceDetailsTable, 0 );
*********************************************************************/

        return $PaymentTransactionInvoiceDetails;
    }

//####################################################################
    // GetPaymentTransactionInvoiceDetailsByPaymentTransactionNumber.

    public function GetPaymentTransactionInvoiceDetailsByPaymentTransactionNumber( $inConnection, $inPaymentTransactionNumber )
    {
        $Sql = "SELECT payment_transaction_number, invoice_number, amount_paid
                FROM {$this->Prefix}payment_transaction_invoice
                WHERE payment_transaction_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $PaymentTransactionNumber );
        $PaymentTransactionNumber = $inPaymentTransactionNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rInvoiceNumber, $rAmountPaid );
        $PaymentTransactionInvoiceDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $rPaymentTransactionNumber;
            $PaymentTransactionInvoiceDetails['invoice_number'] = $rInvoiceNumber;
            $PaymentTransactionInvoiceDetails['amount_paid'] = $rAmountPaid;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentTransactionInvoiceDetailsTable = mysqli_query( $inConnection,
                                                               "SELECT payment_transaction_number, invoice_number, amount_paid
                                                                FROM {$this->Prefix}payment_transaction_invoice
                                                                WHERE payment_transaction_number = {$inPaymentTransactionNumber}" ) or die( mysqli_error( $inConnection ) );
        $PaymentTransactionInvoiceDetails = array();
        while( $Row = mysqli_fetch_assoc( $PaymentTransactionInvoiceDetailsTable ) )
        {
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $Row['payment_transaction_number'];
            $PaymentTransactionInvoiceDetails['invoice_number'] = $Row['invoice_number'];
            $PaymentTransactionInvoiceDetails['amount_paid'] = $Row['amount_paid'];
        }
        mysqli_data_seek( $PaymentTransactionInvoiceDetailsTable, 0 );
*********************************************************************/

        return $PaymentTransactionInvoiceDetails;
    }

//####################################################################
    // GetPaymentTransactionInvoiceDetailsByInvoiceNumber.

    public function GetPaymentTransactionInvoiceDetailsByInvoiceNumber( $inConnection, $inInvoiceNumber )
    {
        $Sql = "SELECT payment_transaction_number, invoice_number, amount_paid
                FROM {$this->Prefix}payment_transaction_invoice
                WHERE invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rInvoiceNumber, $rAmountPaid );
        $PaymentTransactionInvoiceDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $rPaymentTransactionNumber;
            $PaymentTransactionInvoiceDetails['invoice_number'] = $rInvoiceNumber;
            $PaymentTransactionInvoiceDetails['amount_paid'] = $rAmountPaid;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentTransactionInvoiceDetailsTable = mysqli_query( $inConnection,
                                                               "SELECT payment_transaction_number, invoice_number, amount_paid
                                                                FROM {$this->Prefix}payment_transaction_invoice
                                                                WHERE invoice_number = {$inInvoiceNumber}" ) or die( mysqli_error( $inConnection ) );
        $PaymentTransactionInvoiceDetails = array();
        while( $Row = mysqli_fetch_assoc( $PaymentTransactionInvoiceDetailsTable ) )
        {
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $Row['payment_transaction_number'];
            $PaymentTransactionInvoiceDetails['invoice_number'] = $Row['invoice_number'];
            $PaymentTransactionInvoiceDetails['amount_paid'] = $Row['amount_paid'];
        }
        mysqli_data_seek( $PaymentTransactionInvoiceDetailsTable, 0 );
*********************************************************************/

        return $PaymentTransactionInvoiceDetails;
    }

//####################################################################
    // GetPaymentTransactionInvoices.

    public function GetPaymentTransactionInvoices( $inConnection )
    {
        $PaymentTransactionInvoicesTable = mysqli_query( $inConnection,
                                                         "SELECT pti.payment_transaction_number, pti.invoice_number, pti.amount_paid, pti.payment_type, pt.payment_transaction_date, i.custom_invoice_number
                                                          FROM {$this->Prefix}invoice i, {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                                                          WHERE i.invoice_number = pti.invoice_number AND
                                                                pti.payment_transaction_number = pt.payment_transaction_number" ) or die( mysqli_error( $inConnection ) );
        $PaymentTransactionInvoices = array();
        while( $Row = mysqli_fetch_assoc( $PaymentTransactionInvoicesTable ) )
        {
            $PaymentTransactionInvoiceDetails = array();
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $Row['payment_transaction_number'];
            $PaymentTransactionInvoiceDetails['invoice_number'] = $Row['invoice_number'];
            $PaymentTransactionInvoiceDetails['amount_paid'] = $Row['amount_paid'];
            $PaymentTransactionInvoiceDetails['payment_type'] = $Row['payment_type'];
            $PaymentTransactionInvoiceDetails['payment_transaction_date'] = $Row['payment_transaction_date'];
            $PaymentTransactionInvoiceDetails['custom_invoice_number'] = $Row['custom_invoice_number'];
            array_push( $PaymentTransactionInvoices, $PaymentTransactionInvoiceDetails );
        }
        mysqli_data_seek( $PaymentTransactionInvoicesTable, 0 );

        return $PaymentTransactionInvoices;
    }
/*
SELECT pti.payment_transaction_number, pti.invoice_number, pti.amount_paid, pti.payment_type, pt.payment_transaction_date, i.custom_invoice_number
                                                          FROM invoice i, payment_transaction_invoice pti, payment_transaction pt
                                                          WHERE i.invoice_number = pti.invoice_number AND
                                                                pti.payment_transaction_number = pt.payment_transaction_number;

*/

//####################################################################
    // GetPaymentTransactionInvoicesForStatement. Each statement is for one or more invoices, and each invoice has had zero or more payments made on it. This method returns all the payment transactions for all invoices on a particular statement. For example:
/*
Date       | Amount paid | Payment type | Transaction ID | Invoice number
-----------+-------------+--------------+----------------+---------------
26-04-2019 | £200.00     | Payment      | 0000000001     | 0000000001	
26-04-2019 |  £70.00     | Payment      | 0000000002     | 0000000002	
26-04-2019 | £230.00     | Payment      | 0000000004     | 0000000002
*/

    public function GetPaymentTransactionInvoicesForStatement( $inConnection, $inCustomerId, $inStatementYear, $inStatementMonth )
    {
        if( $inStatementMonth == 1 )                            // Remember, a statement is for a set of invoices generated in the
        {                                                       // month preceding the month of the statement. Therefore we must decrement
            $inStatementYear = $inStatementYear - 1;            // the incoming statement's month by 1.
            $inStatementMonth = 12;
        }
        else
        {
            $inStatementMonth = $inStatementMonth - 1;
        }

        $Sql = "SELECT pti.payment_transaction_number, pti.invoice_number, pti.amount_paid, pti.payment_type, pt.payment_transaction_date, i.custom_invoice_number, pt.custom_transaction_id
                FROM {$this->Prefix}invoice i, {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                WHERE i.invoice_number = pti.invoice_number AND
                      pti.payment_transaction_number = pt.payment_transaction_number AND
                      i.customer_id = ? AND
                      YEAR( i.creation_date ) = ? AND
                      MONTH( i.creation_date ) = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iii", $CustomerId, $StatementYear, $StatementMonth );
        $CustomerId = $inCustomerId;
        $StatementYear = $inStatementYear;
        $StatementMonth = $inStatementMonth;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rInvoiceNumber, $rAmountPaid, $rPaymentType, $rPaymentTransactionDate, $rCustomInvoiceNumber, $rCustomTransactionId );
        $PaymentTransactionInvoicesForStatement = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $PaymentTransactionInvoiceDetails = array();
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $rPaymentTransactionNumber;
            $PaymentTransactionInvoiceDetails['invoice_number'] = $rInvoiceNumber;
            $PaymentTransactionInvoiceDetails['amount_paid'] = $rAmountPaid;
            $PaymentTransactionInvoiceDetails['payment_type'] = $rPaymentType;
            $PaymentTransactionInvoiceDetails['payment_transaction_date'] = $rPaymentTransactionDate;
            $PaymentTransactionInvoiceDetails['custom_invoice_number'] = $rCustomInvoiceNumber;
            $PaymentTransactionInvoiceDetails['custom_transaction_id'] = $rCustomTransactionId;
            array_push( $PaymentTransactionInvoicesForStatement, $PaymentTransactionInvoiceDetails );
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentTransactionInvoicesForStatementTable = mysqli_query( $inConnection,
                                                         "SELECT pti.payment_transaction_number, pti.invoice_number, pti.amount_paid, pti.payment_type, pt.payment_transaction_date, i.custom_invoice_number, pt.custom_transaction_id
                                                          FROM {$this->Prefix}invoice i, {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                                                          WHERE i.invoice_number = pti.invoice_number AND
                                                                pti.payment_transaction_number = pt.payment_transaction_number AND
                                                                i.customer_id = {$inCustomerId} AND
                                                                YEAR( i.creation_date ) = {$inStatementYear} AND
                                                                MONTH( i.creation_date ) = {$inStatementMonth}" ) or die( mysqli_error( $inConnection ) );
        $PaymentTransactionInvoicesForStatement = array();
        while( $Row = mysqli_fetch_assoc( $PaymentTransactionInvoicesForStatementTable ) )
        {
            $PaymentTransactionInvoiceDetails = array();
            $PaymentTransactionInvoiceDetails['payment_transaction_number'] = $Row['payment_transaction_number'];
            $PaymentTransactionInvoiceDetails['invoice_number'] = $Row['invoice_number'];
            $PaymentTransactionInvoiceDetails['amount_paid'] = $Row['amount_paid'];
            $PaymentTransactionInvoiceDetails['payment_type'] = $Row['payment_type'];
            $PaymentTransactionInvoiceDetails['payment_transaction_date'] = $Row['payment_transaction_date'];
            $PaymentTransactionInvoiceDetails['custom_invoice_number'] = $Row['custom_invoice_number'];
            $PaymentTransactionInvoiceDetails['custom_transaction_id'] = $Row['custom_transaction_id'];
            array_push( $PaymentTransactionInvoicesForStatement, $PaymentTransactionInvoiceDetails );
        }
        mysqli_data_seek( $PaymentTransactionInvoicesForStatementTable, 0 );
*********************************************************************/

        return $PaymentTransactionInvoicesForStatement;
    }
/*
SELECT pti.payment_transaction_number, pti.invoice_number, pti.amount_paid, pti.payment_type, pt.payment_transaction_date, i.custom_invoice_number
                                                          FROM invoice i, payment_transaction_invoice pti, payment_transaction pt
                                                          WHERE i.invoice_number = pti.invoice_number AND
                                                                pti.payment_transaction_number = pt.payment_transaction_number AND
                                                                i.customer_id = {$inCustomerId} AND
                                                                YEAR( i.creation_date ) = {$inStatementYear} AND
                                                                MONTH( i.creation_date ) = {$inStatementMonth};

*/

//####################################################################
	// GetInvoicesTotalWrittenOffForPeriod. Returns the total written off on all invoices with creation dates between $inFromDate and $inToDate for the given company.

    public function GetInvoicesTotalWrittenOffForPeriod( $inConnection, $inFromDate, $inToDate, $inCompanyId )
    {
        $Sql = "SELECT SUM( pti.amount_paid ) AS invoices_total_written_off
                FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt, {$this->Prefix}customer c
                WHERE pti.payment_transaction_number = pt.payment_transaction_number AND
                      pt.customer_id = c.customer_id AND
                      c.company_id = ? AND
                      pt.payment_transaction_date >= ? AND
                      pt.payment_transaction_date <= ? AND
                      pti.payment_type = 'Write-off'";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CompanyId, $FromDate, $ToDate );
        $CompanyId = $inCompanyId;
        $FromDate = $inFromDate;
        $ToDate = $inToDate;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoicesTotalWritten_off );
        $InvoicesTotalWrittenOffForPeriod = '0.00';
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            if( $rInvoicesTotalWritten_off > 0 )
            {
    			$InvoicesTotalWrittenOffForPeriod = $rInvoicesTotalWritten_off;
            }
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
		$InvoicesTotalWrittenOffForPeriodTable = mysqli_query( $inConnection,
                                                               "SELECT SUM( pti.amount_paid ) AS invoices_total_written_off
                                                                FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt, {$this->Prefix}customer c
                                                                WHERE pti.payment_transaction_number = pt.payment_transaction_number AND
                                                                      pt.customer_id = c.customer_id AND
                                                                      c.company_id = '{$inCompanyId}' AND
                                                                      pt.payment_transaction_date >= '{$inFromDate}' AND
                                                                      pt.payment_transaction_date <= '{$inToDate}' AND
                                                                      pti.payment_type = 'Write-off'" ) or die( mysqli_error( $inConnection ) );
		$InvoicesTotalWrittenOffForPeriod = '0.00';
		while( $Row = mysqli_fetch_assoc( $InvoicesTotalWrittenOffForPeriodTable ) )
		{
            if( $Row['invoices_total_written_off'] > 0 )
            {
    			$InvoicesTotalWrittenOffForPeriod = $Row['invoices_total_written_off'];
            }
		}
*********************************************************************/

        return $InvoicesTotalWrittenOffForPeriod;
    }

/*
SELECT SUM( amount_paid ) AS invoices_total_written_off
FROM payment_transaction_invoice
WHERE payment_type = 'Write-off';

*/
//####################################################################
}


















































//####################################################################
?>
