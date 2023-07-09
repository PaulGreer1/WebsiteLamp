<?php
//####################################################################
// PaymentTransaction( PaymentTransactionNumber, PaymentTransactionDate, AmountPaid, CustomerId )
//####################################################################
class PaymentTransaction
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
    // Insert. Inserts a payment transaction into the payment_transaction table.

    public function Insert( $inConnection, $inPaymentTransactionNumber, $inPaymentTransactionDate, $inAmountPaid, $inCustomerId, $inCustomTransactionId, $inPaymentMethod )
    {
        $Sql = "INSERT INTO {$this->Prefix}payment_transaction( payment_transaction_number, payment_transaction_date, amount_paid, customer_id, custom_transaction_id, payment_method )
                VALUES ( ?, ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "isdiss", $PaymentTransactionNumber, $PaymentTransactionDate, $AmountPaid, $CustomerId, $CustomTransactionId, $PaymentMethod );

        $PaymentTransactionNumber = $inPaymentTransactionNumber;
        $PaymentTransactionDate = $inPaymentTransactionDate;
        $AmountPaid = $inAmountPaid;
        $CustomerId = $inCustomerId;
        $CustomTransactionId = $inCustomTransactionId;
        $PaymentMethod = $inPaymentMethod;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
/**************************************
        $Query = "INSERT INTO {$this->Prefix}payment_transaction( payment_transaction_number, payment_transaction_date, amount_paid, customer_id, custom_transaction_id, payment_method )
                  VALUES ( '{$inPaymentTransactionNumber}', '{$inPaymentTransactionDate}', '{$inAmountPaid}', '{$inCustomerId}', '{$inCustomTransactionId}', '{$inPaymentMethod}' )";

		mysqli_query( $inConnection, $Query ) or die( mysqli_error( $inConnection ) );
***************************************/
    }

//####################################################################
	// DeletePaymentTransaction.

	public function DeletePaymentTransaction( $inConnection, $inPaymentTransactionNumber )
	{
        $Sql = "DELETE
                FROM {$this->Prefix}payment_transaction
                WHERE payment_transaction_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $PaymentTransactionNumber );
        $PaymentTransactionNumber = $inPaymentTransactionNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
	}

//####################################################################
	// UpdatePaymentTransaction.

	public function UpdatePaymentTransaction( $inConnection, $inAmountPaid, $inPaymentTransactionNumber )
	{
        $Sql = "UPDATE {$this->Prefix}payment_transaction
                SET amount_paid = ?
                WHERE payment_transaction_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "di", $AmountPaid, $PaymentTransactionNumber );
        $AmountPaid = $inAmountPaid;
        $PaymentTransactionNumber = $inPaymentTransactionNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
	}

//####################################################################
    // GetPaymentTransaction. Returns the payment transaction with the given payment transaction number.

    public function GetPaymentTransaction( $inConnection, $inPaymentTransactionNumber  )
    {
/*********************************************************************
        $Sql = "SELECT payment_transaction_number, payment_transaction_date, amount_paid, customer_id, custom_transaction_id
                FROM {$this->Prefix}payment_transaction
                WHERE payment_transaction_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $PaymentTransactionNumber );
        $PaymentTransactionNumber = $inPaymentTransactionNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rPaymentTransactionDate, $rAmountPaid, $rCustomerId, $rCustomTransactionId );
        mysqli_stmt_close( $Stmt );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $PaymentTransactionTable below.

*********************************************************************/
        $PaymentTransactionTable = mysqli_query( $inConnection,
                                                 "SELECT *
                                                  FROM {$this->Prefix}payment_transaction
                                                  WHERE payment_transaction_number = {$inPaymentTransactionNumber}" );
        return $PaymentTransactionTable;
    }

//####################################################################
    // GetPaymentTransactionsByCustomerId. Returns and array holding the details of each payment transaction corresponding to the given customer id.

    public function GetPaymentTransactionsByCustomerId( $inConnection, $inCustomerId  )
    {
        $Sql = "SELECT payment_transaction_number, payment_transaction_date, amount_paid, customer_id, custom_transaction_id
                FROM {$this->Prefix}payment_transaction
                WHERE customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CustomerId );
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rPaymentTransactionDate, $rAmountPaid, $rCustomerId, $rCustomTransactionId );
        $PaymentTransactions = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $PaymentTransaction = array();
			$PaymentTransaction['payment_transaction_number'] = $rPaymentTransactionNumber;
			$PaymentTransaction['payment_transaction_date'] = $rPaymentTransactionDate;
			$PaymentTransaction['amount_paid'] = $rAmountPaid;
			$PaymentTransaction['customer_id'] = $rCustomerId;
			$PaymentTransaction['custom_transaction_id'] = $rCustomTransactionId;
            array_push( $PaymentTransactions, $PaymentTransaction );
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentTransactionsTable = mysqli_query( $inConnection,
                                                  "SELECT *
                                                   FROM {$this->Prefix}payment_transaction
                                                   WHERE customer_id = {$inCustomerId}" );
		$PaymentTransactions = array();
		while( $Row = mysqli_fetch_assoc( $PaymentTransactionTable ) )
		{
            $PaymentTransaction = array();
			$PaymentTransaction['payment_transaction_number'] = $Row['payment_transaction_number'];
			$PaymentTransaction['payment_transaction_date'] = $Row['payment_transaction_date'];
			$PaymentTransaction['amount_paid'] = $Row['amount_paid'];
			$PaymentTransaction['customer_id'] = $Row['customer_id'];
			$PaymentTransaction['custom_transaction_id'] = $Row['custom_transaction_id'];
            array_push( $PaymentTransactions, $PaymentTransaction );
		}
        mysqli_data_seek( $PaymentTransactionsTable, 0 );
*********************************************************************/

        return $PaymentTransactions;
    }

//####################################################################
    // GetPaymentsByInvoiceNumber. Returns an associative array holding the details of each payment corresponding to the given invoice number.

    public function GetPaymentsByInvoiceNumber( $inConnection, $inInvoiceNumber  )
    {
        $Sql = "SELECT pti.payment_transaction_number, pt.payment_transaction_date, pti.invoice_number, pti.amount_paid, pt.customer_id, pt.custom_transaction_id
                FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                WHERE pti.payment_transaction_number = pt.payment_transaction_number AND
                      pti.invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rPaymentTransactionDate, $rInvoiceNumber, $rAmountPaid, $rCustomerId, $rCustomTransactionId );
        $Payments = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $Payment = array();
			$Payment['payment_transaction_number'] = $rPaymentTransactionNumber;
			$Payment['payment_transaction_date'] = $rInvoiceNumber;
			$Payment['invoice_number'] = $rAmountPaid;
			$Payment['amount_paid'] = $Row['amount_paid'];
			$Payment['customer_id'] = $rCustomerId;
			$Payment['custom_transaction_id'] = $rCustomTransactionId;
            array_push( $Payments, $Payment );
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentsTable = mysqli_query( $inConnection,
                                       "SELECT pti.payment_transaction_number, pt.payment_transaction_date, pti.invoice_number, pti.amount_paid, pt.customer_id, pt.custom_transaction_id
                                        FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                                        WHERE pti.payment_transaction_number = pt.payment_transaction_number AND
                                              pti.invoice_number = {$inInvoiceNumber}" );
		$Payments = array();
		while( $Row = mysqli_fetch_assoc( $PaymentsTable ) )
		{
            $Payment = array();
			$Payment['payment_transaction_number'] = $Row['payment_transaction_number'];
			$Payment['payment_transaction_date'] = $Row['payment_transaction_date'];
			$Payment['invoice_number'] = $Row['invoice_number'];
			$Payment['amount_paid'] = $Row['amount_paid'];
			$Payment['customer_id'] = $Row['customer_id'];
			$Payment['custom_transaction_id'] = $Row['custom_transaction_id'];
            array_push( $Payments, $Payment );
		}
        mysqli_data_seek( $PaymentsTable, 0 );
*********************************************************************/

        return $Payments;
    }

//####################################################################
    // GetPaymentTransactionsByInvoiceNumberAccoc. Returns an associative array holding the details of each payment transaction corresponding to the given invoice number.

    public function GetPaymentTransactionsByInvoiceNumberAccoc( $inConnection, $inInvoiceNumber  )
    {
        $Sql = "SELECT pt.payment_transaction_number, pt.payment_transaction_date, pt.amount_paid, pt.customer_id, pt.custom_transaction_id
                FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                WHERE pti.payment_transaction_number = pt.payment_transaction_number AND
                      pti.invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rPaymentTransactionDate, $rAmountPaid, $rCustomerId, $rCustomTransactionId );
        $PaymentTransactions = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $PaymentTransaction = array();
			$PaymentTransaction['payment_transaction_number'] = $rPaymentTransactionNumber;
			$PaymentTransaction['payment_transaction_date'] = $rPaymentTransactionDate;
			$PaymentTransaction['amount_paid'] = $rAmountPaid;
			$PaymentTransaction['customer_id'] = $rCustomerId;
			$PaymentTransaction['custom_transaction_id'] = $rCustomTransactionId;
            array_push( $PaymentTransactions, $PaymentTransaction );
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentTransactionsTable = mysqli_query( $inConnection,
                                                  "SELECT pt.payment_transaction_number, pt.payment_transaction_date, pt.amount_paid, pt.customer_id, pt.custom_transaction_id
                                                   FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                                                   WHERE pti.payment_transaction_number = pt.payment_transaction_number AND
                                                         pti.invoice_number = {$inInvoiceNumber}" );
		$PaymentTransactions = array();
		while( $Row = mysqli_fetch_assoc( $PaymentTransactionsTable ) )
		{
            $PaymentTransaction = array();
			$PaymentTransaction['payment_transaction_number'] = $Row['payment_transaction_number'];
			$PaymentTransaction['payment_transaction_date'] = $Row['payment_transaction_date'];
			$PaymentTransaction['amount_paid'] = $Row['amount_paid'];
			$PaymentTransaction['customer_id'] = $Row['customer_id'];
			$PaymentTransaction['custom_transaction_id'] = $Row['custom_transaction_id'];
            array_push( $PaymentTransactions, $PaymentTransaction );
		}
        mysqli_data_seek( $PaymentTransactionsTable, 0 );
*********************************************************************/

        return $PaymentTransactions;
    }

//####################################################################
    // GetPaymentTransactionsByInvoiceNumber. Returns an indexed array holding the details of each payment transaction corresponding to the given invoice number.

    public function GetPaymentTransactionsByInvoiceNumber( $inConnection, $inInvoiceNumber  )
    {
        $Sql = "SELECT pt.payment_transaction_number, pt.payment_transaction_date, pt.amount_paid, pt.customer_id, pt.custom_transaction_id
                FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                WHERE pti.payment_transaction_number = pt.payment_transaction_number AND
                      pti.invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rPaymentTransactionDate, $rAmountPaid, $rCustomerId, $rCustomTransactionId );
        $PaymentTransactions = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $PaymentTransaction = array();
            array_push( $PaymentTransaction, $rPaymentTransactionNumber, $rPaymentTransactionDate, $rAmountPaid, $rCustomerId, $rCustomTransactionId );
            array_push( $PaymentTransactions, $PaymentTransaction );
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentTransactionsTable = mysqli_query( $inConnection,
                                                  "SELECT pt.payment_transaction_number, pt.payment_transaction_date, pt.amount_paid, pt.customer_id, pt.custom_transaction_id
                                                   FROM payment_transaction_invoice pti, payment_transaction pt
                                                   WHERE pti.payment_transaction_number = pt.payment_transaction_number AND
                                                         pti.invoice_number = {$inInvoiceNumber}" );
		$PaymentTransactions = array();
		while( $Row = mysqli_fetch_assoc( $PaymentTransactionsTable ) )
		{
            $PaymentTransaction = array();
            array_push( $PaymentTransaction, $Row['payment_transaction_number'], $Row['payment_transaction_date'], $Row['amount_paid'], $Row['customer_id'], $Row['custom_transaction_id'] );
            array_push( $PaymentTransactions, $PaymentTransaction );
		}
        mysqli_data_seek( $PaymentTransactionsTable, 0 );
*********************************************************************/

        return $PaymentTransactions;
    }

//####################################################################
    // GetPaymentTransactionDetails. Returns an array holding the details of the payment transaction corresponding to the given payment transaction number.

    public function GetPaymentTransactionDetails( $inConnection, $inPaymentTransactionNumber )
    {
        $Sql = "SELECT payment_transaction_number, payment_transaction_date, amount_paid, customer_id, custom_transaction_id
                FROM {$this->Prefix}payment_transaction
                WHERE payment_transaction_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $PaymentTransactionNumber );
        $PaymentTransactionNumber = $inPaymentTransactionNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPaymentTransactionNumber, $rPaymentTransactionDate, $rAmountPaid, $rCustomerId, $rCustomTransactionId );
        $PaymentTransactionDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
    		$PaymentTransactionDetails['payment_transaction_number'] = $rPaymentTransactionNumber;
			$PaymentTransactionDetails['payment_transaction_date'] = $rPaymentTransactionDate;
			$PaymentTransactionDetails['amount_paid'] = $rAmountPaid;
			$PaymentTransactionDetails['customer_id'] = $rCustomerId;
			$PaymentTransactionDetails['custom_transaction_id'] = $rCustomTransactionId;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $PaymentTransactionDetailsTable = mysqli_query( $inConnection,
                                                        "SELECT payment_transaction_number, payment_transaction_date, amount_paid, customer_id, custom_transaction_id
                                                         FROM payment_transaction
                                                         WHERE payment_transaction_number = {$inPaymentTransactionNumber}" );
		$PaymentTransactionDetails = array();
		while( $Row = mysqli_fetch_assoc( $PaymentTransactionDetailsTable ) )
		{
    		$PaymentTransactionDetails['payment_transaction_number'] = $Row['payment_transaction_number'];
			$PaymentTransactionDetails['payment_transaction_date'] = $Row['payment_transaction_date'];
			$PaymentTransactionDetails['amount_paid'] = $Row['amount_paid'];
			$PaymentTransactionDetails['customer_id'] = $Row['customer_id'];
			$PaymentTransactionDetails['custom_transaction_id'] = $Row['custom_transaction_id'];
		}
        mysqli_data_seek( $PaymentTransactionDetailsTable, 0 );
*********************************************************************/

        return $PaymentTransactionDetails;
    }
/*
SELECT payment_transaction_number, payment_transaction_date, amount_paid, customer_id, custom_transaction_id
FROM payment_transaction
WHERE payment_transaction_number = 1;

*/

//####################################################################
    // GetLastPaymentOnInvoice. Given an invoice number, and using the MAX function, returns a table with a single row containing
    // the payment with the latest (last) payment date.

    public function GetLastPaymentOnInvoice( $inConnection, $inInvoiceNumber )
    {
        $Sql = "SELECT MAX( pt.payment_transaction_date ) AS last_payment_date
                FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}payment_transaction pt
                WHERE pt.payment_transaction_number = pti.payment_transaction_number AND
                      pti.invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rLastPaymentDate );
        $LastPaymentOnInvoice = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $LastPaymentOnInvoice['last_payment_date'] = $rLastPaymentDate;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $LastPaymentOnInvoiceTable = mysqli_query( $inConnection,
                                                 "SELECT MAX( pt.payment_transaction_date ) AS last_payment_date
                                                  FROM payment_transaction_invoice pti, payment_transaction pt
                                                  WHERE pt.payment_transaction_number = pti.payment_transaction_number AND
                                                        pti.invoice_number = {$inInvoiceNumber}" );
        $LastPaymentOnInvoice = array();
        while( $Row = mysqli_fetch_assoc( $LastPaymentOnInvoiceTable ) )
        {
            $LastPaymentOnInvoice['last_payment_date'] = $Row['last_payment_date'];
        }
        mysqli_data_seek( $LastPaymentOnInvoiceTable, 0 );
*********************************************************************/

        return $LastPaymentOnInvoice;
    }

//####################################################################
    // GetPaymentTransactionNumbers. 

    public function GetPaymentTransactionNumbers( $inConnection )
    {
        $PaymentTransactionNumbersTable = mysqli_query( $inConnection,
                                                        "SELECT payment_transaction_number
                                                         FROM {$this->Prefix}payment_transaction" );
        $PaymentTransactionNumbers = array();
        while( $Row = mysqli_fetch_assoc( $PaymentTransactionNumbersTable ) )
        {
            array_push( $PaymentTransactionNumbers, intval( $Row['payment_transaction_number'] ) );
        }
        mysqli_data_seek( $PaymentTransactionNumbersTable, 0 );

        return $PaymentTransactionNumbers;
    }

//####################################################################
}


















//####################################################################
?>
