<?php
//####################################################################
// Invoice(  InvoiceNumber, CreationDate, InitialAmount, AmountOutstanding, WriteOffAmount, CustomerId, CreditOrderId )
//####################################################################
class Invoice
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
    // Insert. Inserts an invoice into the Invoice table. ******************** CONVERTED TO MULTI-USER ********************

    public function Insert( $inConnection, $inInvoiceNumber, $inCreationDate, $inInitialAmount, $inAmountOutstanding, $inWriteOffAmount, $inCustomerId, $inCreditOrderId, $inCustomInvoiceNumber )
    {
        $Sql = "INSERT INTO {$this->Prefix}invoice( invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id, credit_order_id, custom_invoice_number )
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "isdddiis", $InvoiceNumber, $CreationDate, $InitialAmount, $AmountOutstanding, $WriteOffAmount, $CustomerId, $CreditOrderId, $CustomInvoiceNumber );

        $InvoiceNumber = $inInvoiceNumber;
        $CreationDate = $inCreationDate;
        $InitialAmount = $inInitialAmount;
        $AmountOutstanding = $inAmountOutstanding;
        $WriteOffAmount = $inWriteOffAmount;
        $CustomerId = $inCustomerId;
        $CreditOrderId = $inCreditOrderId;
        $CustomInvoiceNumber = $inCustomInvoiceNumber;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }
/*********************************************************************
        $Query = "INSERT INTO {$this->Prefix}invoice( invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id, credit_order_id, custom_invoice_number )
                  VALUES ( '{$inInvoiceNumber}', '{$inCreationDate}', '{$inInitialAmount}', '{$inAmountOutstanding}', '{$inWriteOffAmount}', '{$inCustomerId}', '{$inCreditOrderId}', '{$inCustomInvoiceNumber}' )";

        mysqli_query( $inConnection, $Query ) or die( mysqli_error( $inConnection ) );
*********************************************************************/

//####################################################################
	// DeleteInvoice.

	public function DeleteInvoice( $inConnection, $inInvoiceNumber )
	{
        $Sql = "DELETE
                FROM {$this->Prefix}invoice
                WHERE invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
	}

//####################################################################
	// AddAmountPaidToAmountOutstanding.

	public function AddAmountPaidToAmountOutstanding( $inConnection, $inAmountPaid, $inInvoiceNumber )
	{
        $Sql = "UPDATE {$this->Prefix}invoice
                SET amount_outstanding = amount_outstanding + ?
                WHERE invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "di", $AmountPaid, $InvoiceNumber );
        $AmountPaid = $inAmountPaid;
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
	}

//####################################################################
	// UpdateInvoice.

	public function UpdateInvoice( $inConnection, $inAmountOutstanding, $inInvoiceNumber )
	{
        $Sql = "UPDATE {$this->Prefix}invoice
                SET amount_outstanding = ?
                WHERE invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "di", $AmountOutstanding, $InvoiceNumber );
        $AmountOutstanding = $inAmountOutstanding;
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
	}

//####################################################################
    // GetInvoice. Returns the invoice with the given invoice number. ******************** CONVERTED TO MULTI-USER ********************

    public function GetInvoice( $inConnection, $inInvoiceNumber  )
    {
/*********************************************************************
        $Sql = "SELECT invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id. credit_order_id, custom_invoice_number
                FROM {$this->Prefix}invoice
                WHERE invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoiceNumber, $rCreationDate, $rInitialAmount, $rAmountOutstanding, $rWriteOffAmount, $rCustomerId, $rCreditOrderId, $rCustomInvoiceNumber );
        mysqli_stmt_close( $Stmt );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $CreditOrderTable below.

*********************************************************************/
        $InvoiceTable = mysqli_query( $inConnection,
                                      "SELECT *
                                       FROM {$this->Prefix}invoice
                                       WHERE invoice_number = {$inInvoiceNumber}" );
        return $InvoiceTable;
    }

//####################################################################
    // GetAllInvoices. Returns a table of all invoices.

    public function GetAllInvoices( $inConnection )
    {
        $AllInvoicesTable = mysqli_query( $inConnection,
                                          "SELECT *
                                           FROM {$this->Prefix}invoice" );
        return $AllInvoicesTable;
    }

//####################################################################
	// GetInvoicesTotal. Returns the total of all invoices for the given company.

    public function GetInvoicesTotal( $inConnection, $inCompanyId )
    {
        $Sql = "SELECT SUM( i.initial_amount ) AS invoices_total
                FROM {$this->Prefix}invoice i, {$this->Prefix}customer c
                WHERE i.customer_id = c.customer_id AND
                      c.company_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CompanyId );
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoicesTotal );
        $InvoicesTotal = '0.00';
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			if( $rInvoicesTotal > 0 )
            {
                $InvoicesTotal = $rInvoicesTotal;
            }
        }

        mysqli_stmt_close( $Stmt );

        return $InvoicesTotal;
    }

/*********************************************************************
		$InvoicesTotalTable = mysqli_query( $inConnection,
                                            "SELECT SUM( i.initial_amount ) AS invoices_total
                                             FROM invoice i, customer c
                                             WHERE i.customer_id = c.customer_id AND
                                                   c.company_id = '{$inCompanyId}'" );

//		$InvoicesTotalTable = mysqli_query( $inConnection,
//                                            "SELECT SUM( initial_amount ) AS invoices_total
//                                             FROM invoice" );
		$InvoicesTotal = '0.00';
		while( $Row = mysqli_fetch_assoc( $InvoicesTotalTable ) )
		{
            if( $Row['invoices_total'] > 0 )
            {
    			$InvoicesTotal = $Row['invoices_total'];
            }
		}
*********************************************************************/

//####################################################################
	// GetInvoicesTotalForPeriod. Returns the total of all invoices with creation dates between $inFromDate and $inToDate for the given company.

    public function GetInvoicesTotalForPeriod( $inConnection, $inFromDate, $inToDate, $inCompanyId )
    {
        $Sql = "SELECT SUM( i.initial_amount ) AS invoices_total
                FROM {$this->Prefix}invoice i, {$this->Prefix}customer c
                WHERE i.customer_id = c.customer_id AND
                      c.company_id = ? AND
                      i.creation_date >= ? AND
                      i.creation_date <= ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CompanyId, $FromDate, $ToDate );
        $CompanyId = $inCompanyId;
        $FromDate = $inFromDate;
        $ToDate = $inToDate;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoicesTotalForPeriod );
        $InvoicesTotalForPeriod = '0.00';
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			if( $rInvoicesTotalForPeriod > 0 )
            {
                $InvoicesTotalForPeriod = $rInvoicesTotalForPeriod;
            }
        }

        mysqli_stmt_close( $Stmt );

        return $InvoicesTotalForPeriod;
    }

/*********************************************************************
		$InvoicesTotalForPeriodTable = mysqli_query( $inConnection,
                                                     "SELECT SUM( i.initial_amount ) AS invoices_total
                                                      FROM invoice i, customer c
                                                      WHERE i.customer_id = c.customer_id AND
                                                            c.company_id = '{$inCompanyId}' AND
                                                            i.creation_date >= '{$inFromDate}' AND
                                                            i.creation_date <= '{$inToDate}'" );
		$InvoicesTotalForPeriod = '0.00';
		while( $Row = mysqli_fetch_assoc( $InvoicesTotalForPeriodTable ) )
		{
            if( $Row['invoices_total'] > 0 )
            {
    			$InvoicesTotalForPeriod = $Row['invoices_total'];
            }
		}
*********************************************************************/

//####################################################################
	// GetInvoicesTotalOverdueForPeriod. Returns the total overdue of all invoices with creation dates between $inFromDate and $inToDate for the given company. ******************** CONVERTED TO MULTI-USER ********************

    public function GetInvoicesTotalOverdueForPeriod( $inConnection, $inFromDate, $inToDate, $inCompanyId )
    {
        $Sql = "SELECT SUM( i.amount_outstanding ) AS invoices_total_overdue
                FROM {$this->Prefix}invoice i, {$this->Prefix}customer c
                WHERE i.customer_id = c.customer_id AND
                      c.company_id = '{$inCompanyId}' AND
                      i.creation_date >= '{$inFromDate}' AND
                      i.creation_date <= '{$inToDate}' AND
                      MONTH( NOW() ) > MONTH( LAST_DAY( DATE_ADD( LAST_DAY( i.creation_date ), INTERVAL 1 MONTH ) ) )";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CompanyId, $FromDate, $ToDate );
        $CompanyId = $inCompanyId;
        $FromDate = $inFromDate;
        $ToDate = $inToDate;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoicesTotalOverdueForPeriod );
        $InvoicesTotalOverdueForPeriod = '0.00';
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			if( $rInvoicesTotalOverdueForPeriod > 0 )
            {
                $InvoicesTotalOverdueForPeriod = $rInvoicesTotalOverdueForPeriod;
            }
        }

        mysqli_stmt_close( $Stmt );

        return $InvoicesTotalOverdueForPeriod;
    }

/*********************************************************************
		$InvoicesTotalOverdueForPeriodTable = mysqli_query( $inConnection,
                                                            "SELECT SUM( i.amount_outstanding ) AS invoices_total_overdue
                                                             FROM {$this->Prefix}invoice i, {$this->Prefix}customer c
                                                             WHERE i.customer_id = c.customer_id AND
                                                                   c.company_id = '{$inCompanyId}' AND
                                                                   i.creation_date >= '{$inFromDate}' AND
                                                                   i.creation_date <= '{$inToDate}' AND
                                                                   MONTH( NOW() ) > MONTH( LAST_DAY( DATE_ADD( LAST_DAY( i.creation_date ), INTERVAL 1 MONTH ) ) )" );
		$InvoicesTotalOverdueForPeriod = '0.00';
		while( $Row = mysqli_fetch_assoc( $InvoicesTotalOverdueForPeriodTable ) )
		{
            if( $Row['invoices_total_overdue'] > 0 )
            {
    			$InvoicesTotalOverdueForPeriod = $Row['invoices_total_overdue'];
            }
		}
*********************************************************************/

/*
SELECT SUM( amount_outstanding ) AS invoices_total_overdue
FROM invoice
WHERE MONTH( NOW() ) > MONTH( DATE_ADD( LAST_DAY( creation_date ), INTERVAL 1 MONTH ) );

SELECT SUM( amount_outstanding ) AS invoices_total_overdue
FROM invoice
WHERE MONTH( NOW() ) > MONTH( LAST_DAY( DATE_ADD( LAST_DAY( creation_date ), INTERVAL 1 MONTH ) ) );

SELECT MONTH( DATE_ADD( LAST_DAY( creation_date ), INTERVAL 1 MONTH ) )
FROM invoice;

*/
//####################################################################
	// ***** DEPRECATED - see PaymentTransactionInvoice::GetInvoicesTotalWrittenOffForPeriod instead.
    // GetInvoicesTotalWrittenOffForPeriod. Returns the total written off on all invoices with creation dates between $inFromDate and $inToDate for the given company. ******************** CONVERTED TO MULTI-USER ********************

    public function GetInvoicesTotalWrittenOffForPeriod( $inConnection, $inFromDate, $inToDate, $inCompanyId )
    {
		$InvoicesTotalWrittenOffForPeriodTable = mysqli_query( $inConnection,
                                                            "SELECT SUM( i.write_off_amount ) AS invoices_total_written_off
                                                             FROM {$this->Prefix}invoice i, {$this->Prefix}customer c
                                                             WHERE i.customer_id = c.customer_id AND
                                                                   c.company_id = '{$inCompanyId}' AND
                                                                   i.creation_date >= '{$inFromDate}' AND
                                                                   i.creation_date <= '{$inToDate}'" );
		$InvoicesTotalWrittenOffForPeriod = '0.00';
		while( $Row = mysqli_fetch_assoc( $InvoicesTotalWrittenOffForPeriodTable ) )
		{
            if( $Row['invoices_total_written_off'] > 0 )
            {
    			$InvoicesTotalWrittenOffForPeriod = $Row['invoices_total_written_off'];
            }
		}

        return $InvoicesTotalWrittenOffForPeriod;
    }

/*
SELECT SUM( write_off_amount ) AS invoices_total_written_off
FROM invoice;

*/
//####################################################################
    // GetStatementDueDate. Return the due date of the statement identified by the given customer id, year and month.

    public function GetStatementDueDate( $inConnection, $inCustomerId, $inYear, $inMonth, $inDecrementMonth = 0 )
    {
        if( $inDecrementMonth )
        {
            if( $inMonth == 1 )
            {
                $inYear = $inYear - 1;
                $inMonth = 12;
            }
            else
            {
                $inMonth = $inMonth - 1;
            }
        }

        $Sql = "SELECT LAST_DAY( DATE_ADD( LAST_DAY( creation_date ), INTERVAL 1 MONTH ) ) AS statement_due_date
                FROM {$this->Prefix}invoice
                WHERE customer_id = {$inCustomerId} AND
                      YEAR( creation_date ) = {$inYear} AND
                      MONTH( creation_date ) = {$inMonth}";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CustomerId, $Year, $Month );
        $CustomerId = $inCustomerId;
        $Year = $inYear;
        $Month = $inMonth;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStatementDueDate );
        $StatementDueDate = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			$StatementDueDate['statement_due_date'] = $rStatementDueDate;
        }

        mysqli_stmt_close( $Stmt );

        return $StatementDueDate;
    }

/*********************************************************************
    	$StatementDueDateTable = mysqli_query( $inConnection,
                                               "SELECT LAST_DAY( DATE_ADD( LAST_DAY( creation_date ), INTERVAL 1 MONTH ) ) AS statement_due_date
                                                FROM {$this->Prefix}invoice
                                                WHERE customer_id = {$inCustomerId} AND
                                                      YEAR( creation_date ) = {$inYear} AND
                                                      MONTH( creation_date ) = {$inMonth}" );
        $StatementDueDate = array();
        while( $Row = mysqli_fetch_assoc( $StatementDueDateTable ) )
        {
           $StatementDueDate['statement_due_date'] = $Row['statement_due_date'];
        }
        mysqli_data_seek( $StatementDueDateTable, 0 );
*********************************************************************/

/*
SELECT LAST_DAY( DATE_ADD( LAST_DAY( creation_date ), INTERVAL 1 MONTH ) ) AS statement_due_date
FROM invoice
WHERE customer_id = 1 AND
      YEAR( creation_date ) = 2018 AND
      MONTH( creation_date ) = 06;

*/
//####################################################################
	// GetCustomerStatements. For all customers of the given company, returns the statements currently on credit as an array of indexed arrays.

    public function GetCustomerStatements( $inConnection, $inCompanyId )
    {
        $Sql = "SELECT i.customer_id,
                       DATE_ADD( LAST_DAY( MIN( i.creation_date ) ), INTERVAL 1 DAY ) AS statement_date,
                       SUM( i.initial_amount ) AS statement_amount,
                       SUM( i.amount_outstanding ) AS amount_outstanding,
                       LAST_DAY( DATE_ADD( LAST_DAY( MIN( i.creation_date ) ), INTERVAL 1 MONTH ) ) AS statement_due_date
                FROM {$this->Prefix}invoice i, {$this->Prefix}customer c
                WHERE i.customer_id = c.customer_id AND
                      c.company_id = ?
                GROUP BY i.customer_id, YEAR( i.creation_date ) DESC, MONTH( i.creation_date ) DESC";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CompanyId );
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCustomerId, $rStatementDate, $rStatementAmount, $rAmountOutstanding, $rStatementDueDate );
		$CustomerStatements = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			$CustomerStatement = array();
			array_push( $CustomerStatement, $rCustomerId, $rStatementDate, $rStatementAmount, $rAmountOutstanding, $rStatementDueDate );
			array_push( $CustomerStatements, $CustomerStatement );
        }
        mysqli_stmt_close( $Stmt );

        return $CustomerStatements;
    }

/*********************************************************************
		$CustomerStatementsTable = mysqli_query( $inConnection,
                                                 "SELECT i.customer_id,
                                                         DATE_ADD( LAST_DAY( MIN( i.creation_date ) ), INTERVAL 1 DAY ) AS statement_date,
                                                         SUM( i.initial_amount ) AS statement_amount,
                                                         SUM( i.amount_outstanding ) AS amount_outstanding,
                                                         LAST_DAY( DATE_ADD( LAST_DAY( MIN( i.creation_date ) ), INTERVAL 1 MONTH ) ) AS statement_due_date
                                                  FROM {$this->Prefix}invoice i, {$this->Prefix}customer c
                                                  WHERE i.customer_id = c.customer_id AND
                                                        c.company_id = '{$inCompanyId}'
                                                  GROUP BY i.customer_id, YEAR( i.creation_date ) DESC, MONTH( i.creation_date ) DESC" );
		$CustomerStatements = array();
		while( $Row = mysqli_fetch_assoc( $CustomerStatementsTable ) )
		{
			$CustomerStatement = array();
			array_push( $CustomerStatement, $Row['customer_id'], $Row['statement_date'], $Row['statement_amount'], $Row['amount_outstanding'], $Row['statement_due_date'] );
			array_push( $CustomerStatements, $CustomerStatement );
		}
        mysqli_data_seek( $CustomerStatementsTable, 0 );
*********************************************************************/

//####################################################################
    // GetStatementInvoices. Each statement is for one or more invoices. Given a customer id, a year and a month, this method returns all the invoices for the statement.
    //
    // Be careful when providing values for the year and month. Remember that a statement's month is the month after the month of its invoices - this is shown by the way in which the 'statement_date' attribute is calculated in the SELECT statement in the invoices, then you can pass an extra parameter 1 to have this method adjust the year and month for you.

    public function GetStatementInvoices( $inConnection, $inCustomerId, $inYear, $inMonth, $inDecrementMonth = 0 )
    {
        if( $inDecrementMonth )
        {
            if( $inMonth == 1 )
            {
                $inYear = $inYear - 1;
                $inMonth = 12;
            }
            else
            {
                $inMonth = $inMonth - 1;
            }
        }

        $Sql = "SELECT invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id, credit_order_id, custom_invoice_number
                FROM {$this->Prefix}invoice
                WHERE customer_id = ? AND
                      YEAR( creation_date ) = ? AND
                      MONTH( creation_date ) = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CustomerId, $Year, $Month );
        $CustomerId = $inCustomerId;
        $Year = $inYear;
        $Month = $inMonth;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoiceNumber, $rCreationDate, $rInitialAmount, $rAmountOutstanding, $rWriteOffAmount, $rCustomerId, $rCreditOrderId, $rCustomInvoiceNumber );
        $Invoices = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $InvoiceAttributes = array();
            $InvoiceAttributes['invoice_number'] = $rInvoiceNumber;
            $InvoiceAttributes['creation_date'] = $rCreationDate;
            $InvoiceAttributes['initial_amount'] = $rInitialAmount;
            $InvoiceAttributes['amount_outstanding'] = $rAmountOutstanding;
            $InvoiceAttributes['write_off_amount'] = $rWriteOffAmount;
            $InvoiceAttributes['customer_id'] = $rCustomerId;
            $InvoiceAttributes['credit_order_id'] = $rCreditOrderId;
            $InvoiceAttributes['custom_invoice_number'] = $rCustomInvoiceNumber;
            array_push( $Invoices, $InvoiceAttributes );
        }

        mysqli_stmt_close( $Stmt );

        return $Invoices;
    }

/*********************************************************************
    	$InvoicesTable = mysqli_query( $inConnection,
                                       "SELECT invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id, credit_order_id, custom_invoice_number
                                        FROM {$this->Prefix}invoice
                                        WHERE customer_id = {$inCustomerId} AND
                                              YEAR( creation_date ) = '{$inYear}' AND
                                              MONTH( creation_date ) = '{$inMonth}'" ) or die( mysqli_error( $inConnection ) );
        $Invoices = array();
        while( $Row = mysqli_fetch_assoc( $InvoicesTable ) )
        {
            $InvoiceAttributes = array();
            $InvoiceAttributes['invoice_number'] = $Row['invoice_number'];
            $InvoiceAttributes['creation_date'] = $Row['creation_date'];
            $InvoiceAttributes['initial_amount'] = $Row['initial_amount'];
            $InvoiceAttributes['amount_outstanding'] = $Row['amount_outstanding'];
            $InvoiceAttributes['write_off_amount'] = $Row['write_off_amount'];
            $InvoiceAttributes['customer_id'] = $Row['customer_id'];
            $InvoiceAttributes['credit_order_id'] = $Row['credit_order_id'];
            $InvoiceAttributes['custom_invoice_number'] = $Row['custom_invoice_number'];
            array_push( $Invoices, $InvoiceAttributes );
        }
        mysqli_data_seek( $InvoicesTable, 0 );
*********************************************************************/

/******************************************************
From: https://stackoverflow.com/questions/41673291/how-to-sort-by-month-year-in-mysql
An example of sorting by year, month:
-----------------------------------------
SELECT *
FROM traffic
WHERE '2015'<= year AND
      year <='2015' AND
      NOT ( ( 2015 = year AND month < 05) OR
            ( 2015 = year AND month > 11) )
ORDER BY Year * 1, month * 1;
-----------------------------------------

* 1 will convert string data type into month integer.
******************************************************/

//####################################################################
    // GetStatementAmountOutstanding.

    public function GetStatementAmountOutstanding( $inConnection, $inCustomerId, $inYear, $inMonth, $inDecrementMonth = 0 )
    {
        if( $inDecrementMonth )
        {
            if( $inMonth == 1 )
            {
                $inYear = $inYear - 1;
                $inMonth = 12;
            }
            else
            {
                $inMonth = $inMonth - 1;
            }
        }

        $Sql = "SELECT SUM( amount_outstanding ) AS statement_amount_outstanding
                FROM {$this->Prefix}invoice
                WHERE customer_id = ? AND
                      YEAR( creation_date ) = ? AND
                      MONTH( creation_date ) = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CustomerId, $Year, $Month );
        $CustomerId = $inCustomerId;
        $Year = $inYear;
        $Month = $inMonth;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStatementAmountOutstanding );
        $StatementAmountOutstanding = 0.00;
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $StatementAmountOutstanding = $rStatementAmountOutstanding;
        }

        mysqli_stmt_close( $Stmt );

        return $StatementAmountOutstanding;
    }

/*********************************************************************
    	$StatementAmountOutstandingTable = mysqli_query( $inConnection,
                                                         "SELECT SUM( amount_outstanding ) AS statement_amount_outstanding
                                                          FROM invoice
                                                          WHERE customer_id = {$inCustomerId} AND
                                                                YEAR( creation_date ) = {$inYear} AND
                                                                MONTH( creation_date ) = {$inMonth}" ) or die( mysqli_error( $inConnection ) );
        $StatementAmountOutstanding = 0.00;
        while( $Row = mysqli_fetch_assoc( $StatementAmountOutstandingTable ) )
        {
            $StatementAmountOutstanding = $Row['statement_amount_outstanding'];
        }
        mysqli_data_seek( $StatementAmountOutstandingTable, 0 );
*********************************************************************/

//####################################################################
    // GetOneCustomersInvoices. Given a customer id, return an array of that customer's invoices.

    public function GetOneCustomersInvoices( $inConnection, $inCustomerId )
    {
        $Sql = "SELECT invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id, credit_order_id
                FROM {$this->Prefix}invoice
                WHERE customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CustomerId );
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoiceNumber, $rCreationDate, $rInitialAmount, $rAmountOutstanding, $rWriteOffAmount, $rCustomerId, $rCreditOrderId );
        $Invoices = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $InvoiceAttributes = array();
            $InvoiceAttributes['invoice_number'] = $rInvoiceNumber;
            $InvoiceAttributes['creation_date'] = $rCreationDate;
            $InvoiceAttributes['initial_amount'] = $rInitialAmount;
            $InvoiceAttributes['amount_outstanding'] = $rAmountOutstanding;
            $InvoiceAttributes['write_off_amount'] = $rWriteOffAmount;
            $InvoiceAttributes['customer_id'] = $rCustomerId;
            $InvoiceAttributes['credit_order_id'] = $rCreditOrderId;
            array_push( $Invoices, $InvoiceAttributes );
        }

        mysqli_stmt_close( $Stmt );

        return $Invoices;
    }

/*********************************************************************
    	$InvoicesTable = mysqli_query( $inConnection,
                                       "SELECT invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id, credit_order_id
                                        FROM invoice
                                        WHERE customer_id = {$inCustomerId}" );
        $Invoices = array();
        while( $Row = mysqli_fetch_assoc( $InvoicesTable ) )
        {
            $InvoiceAttributes = array();
            $InvoiceAttributes['invoice_number'] = $Row['invoice_number'];
            $InvoiceAttributes['creation_date'] = $Row['creation_date'];
            $InvoiceAttributes['initial_amount'] = $Row['initial_amount'];
            $InvoiceAttributes['amount_outstanding'] = $Row['amount_outstanding'];
            $InvoiceAttributes['write_off_amount'] = $Row['write_off_amount'];
            $InvoiceAttributes['customer_id'] = $Row['customer_id'];
            $InvoiceAttributes['credit_order_id'] = $Row['credit_order_id'];
            array_push( $Invoices, $InvoiceAttributes );
        }
        mysqli_data_seek( $InvoicesTable, 0 );
*********************************************************************/

//####################################################################
    // GetOneCustomersInvoicesTotal. Given a customer id, return the total amount outstanding on all the customer's invoices.

    public function GetOneCustomersInvoicesTotal( $inConnection, $inCustomerId )
    {
        $Sql = "SELECT SUM( amount_outstanding ) AS total_amount_outstanding
                FROM {$this->Prefix}invoice
                WHERE customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CustomerId );
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rTotalAmountOutstanding );
        $OneCustomersInvoicesTotal = 0.00;
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $OneCustomersInvoicesTotal = $rTotalAmountOutstanding;
        }

        mysqli_stmt_close( $Stmt );

        return $OneCustomersInvoicesTotal;
    }

/*********************************************************************
		$OneCustomersInvoicesTotalTable = mysqli_query( $inConnection,
                                                        "SELECT SUM( amount_outstanding ) AS total_amount_outstanding
                                                         FROM invoice
                                                         WHERE customer_id = '{$inCustomerId}'" );
		$OneCustomersInvoicesTotal = 0.00;
		while( $Row = mysqli_fetch_assoc( $OneCustomersInvoicesTotalTable ) )
		{
			$OneCustomersInvoicesTotal = $Row['total_amount_outstanding'];
		}
*********************************************************************/

//####################################################################
	// GetOneCustomersStatements. Similar to GetCustomerStatements, only we return an array of a particular customer's statements, we add:
    // "HAVING customer_id = '{$inCustomerId}'" after the GROUP BY clause.
/*
[1]
MIN - get the lowest creation_date in the year/month group...
LAST_DAY - get the date of the last day of the month in the date returned by MIN...
DATE_ADD - add one day to the date returned by LAST_DAY...this gives us the date of the first day of the month following the month in creation date...
*/

    public function GetOneCustomersStatements( $inConnection, $inCustomerId )
    {
        $Sql = "SELECT customer_id,
                       DATE_ADD( LAST_DAY( MIN( creation_date ) ), INTERVAL 1 DAY ) AS statement_date,
                       SUM( initial_amount ) AS statement_amount,
                       SUM( amount_outstanding ) AS amount_outstanding,
                       LAST_DAY( DATE_ADD( LAST_DAY( MIN( creation_date ) ), INTERVAL 1 MONTH ) ) AS statement_due_date,
                       YEAR( creation_date ) AS statement_year,
                       MONTH( creation_date ) AS statement_month
                FROM {$this->Prefix}invoice
                GROUP BY customer_id, YEAR( creation_date ) DESC, MONTH( creation_date ) DESC
                HAVING customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CustomerId );
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCustomer_id, $rStatementDate, $rStatementAmount, $rAmountOutstanding, $rStatementDueDate, $rStatementYear, $rStatementMonth );
        $OneCustomersStatements = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $OneCustomersStatement = array();
            array_push( $OneCustomersStatement, $rCustomer_id, $rStatementDate, $rStatementAmount, $rAmountOutstanding, $rStatementDueDate, $rStatementYear, $rStatementMonth );
            array_push( $OneCustomersStatements, $OneCustomersStatement );
        }

        mysqli_stmt_close( $Stmt );

        return $OneCustomersStatements;
    }

/*********************************************************************
		$OneCustomersStatementsTable = mysqli_query( $inConnection,
                                                     "SELECT customer_id,
                                                             DATE_ADD( LAST_DAY( MIN( creation_date ) ), INTERVAL 1 DAY ) AS statement_date,
                                                             SUM( initial_amount ) AS statement_amount,
                                                             SUM( amount_outstanding ) AS amount_outstanding,
                                                             LAST_DAY( DATE_ADD( LAST_DAY( MIN( creation_date ) ), INTERVAL 1 MONTH ) ) AS statement_due_date,
                                                             YEAR( creation_date ) AS statement_year,
                                                             MONTH( creation_date ) AS statement_month
                                                      FROM {$this->Prefix}invoice
                                                      GROUP BY customer_id, YEAR( creation_date ) DESC, MONTH( creation_date ) DESC
                                                      HAVING customer_id = '{$inCustomerId}'" );
		$OneCustomersStatements = array();
		while( $Row = mysqli_fetch_assoc( $OneCustomersStatementsTable ) )
		{
            $OneCustomersStatement = array();
            array_push( $OneCustomersStatement, $Row['customer_id'], $Row['statement_date'], $Row['statement_amount'], $Row['amount_outstanding'], $Row['statement_due_date'], $Row['statement_year'], $Row['statement_month'] );
            array_push( $OneCustomersStatements, $OneCustomersStatement );

//			$OneCustomersStatements['customer_id'] = $Row['customer_id'];
//			$OneCustomersStatements['statement_date'] = $Row['statement_date'];
//			$OneCustomersStatements['statement_amount'] = $Row['statement_amount'];
//			$OneCustomersStatements['amount_outstanding'] = $Row['amount_outstanding'];
//			$OneCustomersStatements['statement_due_date'] = $Row['statement_due_date'];
//			$OneCustomersStatements['statement_year'] = $Row['statement_year'];
//			$OneCustomersStatements['statement_month'] = $Row['statement_month'];
		}
        mysqli_data_seek( $OneCustomersStatementsTable, 0 );
*********************************************************************/

//####################################################################
    // GetInvoiceDetails. Return the details of the invoice with $inInvoiceNumber.

    public function GetInvoiceDetails( $inConnection, $inInvoiceNumber )
    {
        $Sql = "SELECT invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id, credit_order_id
                FROM {$this->Prefix}invoice
                WHERE invoice_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoiceNumber, $rCreationDate, $rInitialAmount, $rAmountOutstanding, $rWriteOffAmount, $rCustomerId, $rCreditOrderId );
        $InvoiceDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
           $InvoiceDetails['invoice_number'] = $rInvoiceNumber;
           $InvoiceDetails['creation_date'] = $rCreationDate;
           $InvoiceDetails['initial_amount'] = $rInitialAmount;
           $InvoiceDetails['amount_outstanding'] = $rAmountOutstanding;
           $InvoiceDetails['write_off_amount'] = $rWriteOffAmount;
           $InvoiceDetails['customer_id'] = $rCustomerId;
           $InvoiceDetails['credit_order_id'] = $rCreditOrderId;
        }

        mysqli_stmt_close( $Stmt );

        return $InvoiceDetails;
    }

/*********************************************************************
        $InvoiceDetailsTable = mysqli_query( $inConnection,
                                            "SELECT invoice_number, creation_date, initial_amount, amount_outstanding, write_off_amount, customer_id, credit_order_id
                                             FROM {$this->Prefix}invoice
                                             WHERE invoice_number = {$inInvoiceNumber}" );
        $InvoiceDetails = array();
        while( $Row = mysqli_fetch_assoc( $InvoiceDetailsTable ) )
        {
           $InvoiceDetails['invoice_number'] = $Row['invoice_number'];
           $InvoiceDetails['creation_date'] = $Row['creation_date'];
           $InvoiceDetails['initial_amount'] = $Row['initial_amount'];
           $InvoiceDetails['amount_outstanding'] = $Row['amount_outstanding'];
           $InvoiceDetails['write_off_amount'] = $Row['write_off_amount'];
           $InvoiceDetails['customer_id'] = $Row['customer_id'];
           $InvoiceDetails['credit_order_id'] = $Row['credit_order_id'];
        }
        mysqli_data_seek( $InvoiceDetailsTable, 0 );
*********************************************************************/

//####################################################################
	// GetOneCustomersStatement. Return the details of the statement with the given customer id, year and month. Remember that a statement's month is the
    // month after the month of its invoices - this is shown by the way in which the 'statement_date' attribute is calculated in the SELECT statement in
    // the GetCustomerStatements method above. If you are passing the year and month of the statement and not the statement's invoices, then you can
    // pass an extra parameter 1 to have this method adjust the year and month for you.

    public function GetOneCustomersStatement( $inConnection, $inCustomerId, $inStatementYear, $inStatementMonth, $inDecrementMonth = 0 )
    {
        if( $inDecrementMonth )
        {
            if( $inStatementMonth == 1 )
            {
                $inStatementYear = $inStatementYear - 1;
                $inStatementMonth = 12;
            }
            else
            {
                $inStatementMonth = $inStatementMonth - 1;
            }
        }

        $Sql = "SELECT customer_id,
                       DATE_ADD( LAST_DAY( MIN( creation_date ) ), INTERVAL 1 DAY ) AS statement_date,
                       SUM( initial_amount ) AS statement_amount,
                       SUM( amount_outstanding ) AS amount_outstanding,
                       LAST_DAY( DATE_ADD( LAST_DAY( MIN( creation_date ) ), INTERVAL 1 MONTH ) ) AS statement_due_date,
                       YEAR( creation_date ) AS statement_year,
                       MONTH( creation_date ) AS statement_month
                FROM {$this->Prefix}invoice
                WHERE customer_id = ? AND
                      YEAR( creation_date ) = ? AND
                      MONTH( creation_date ) = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CustomerId, $StatementYear, $StatementMonth );
        $CustomerId = $inCustomerId;
        $StatementYear = $inStatementYear;
        $StatementMonth = $inStatementMonth;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCustomerId, $rStatementDate, $rStatementAmount, $rAmountOutstanding, $rStatementDueDate, $rStatementYear, $rStatementMonth );
        $OneCustomersStatement = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            array_push( $OneCustomersStatement, $rCustomerId, $rStatementDate, $rStatementAmount, $rAmountOutstanding, $rStatementDueDate, $rStatementYear, $rStatementMonth );
        }

        mysqli_stmt_close( $Stmt );

        return $OneCustomersStatement;
    }

/*********************************************************************
		$OneCustomersStatementTable = mysqli_query( $inConnection,
                                                     "SELECT customer_id,
                                                             DATE_ADD( LAST_DAY( MIN( creation_date ) ), INTERVAL 1 DAY ) AS statement_date,
                                                             SUM( initial_amount ) AS statement_amount,
                                                             SUM( amount_outstanding ) AS amount_outstanding,
                                                             LAST_DAY( DATE_ADD( LAST_DAY( MIN( creation_date ) ), INTERVAL 1 MONTH ) ) AS statement_due_date,
                                                             YEAR( creation_date ) AS statement_year,
                                                             MONTH( creation_date ) AS statement_month
                                                      FROM {$this->Prefix}invoice
                                                      WHERE customer_id = {$inCustomerId} AND
                                                            YEAR( creation_date ) = {$inStatementYear} AND
                                                            MONTH( creation_date ) = {$inStatementMonth}" );
		$OneCustomersStatement = array();
		while( $Row = mysqli_fetch_assoc( $OneCustomersStatementTable ) )
		{
            //$OneCustomersStatement = array();
            array_push( $OneCustomersStatement, $Row['customer_id'], $Row['statement_date'], $Row['statement_amount'], $Row['amount_outstanding'], $Row['statement_due_date'], $Row['statement_year'], $Row['statement_month'] );
		}
        mysqli_data_seek( $OneCustomersStatementTable, 0 );
*********************************************************************/

//####################################################################
    // GetInvoicesByPaymentTransactionNumber. Returns an array of invoices for a particular payment transaction.

    public function GetInvoicesByPaymentTransactionNumber( $inConnection, $inPaymentTransactionNumber )
    {
        $Sql = "SELECT i.invoice_number, i.creation_date, i.initial_amount, i.amount_outstanding, i.write_off_amount, i.customer_id, i.credit_order_id
                FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}invoice i
                WHERE pti.invoice_number = i.invoice_number AND
                      pti.payment_transaction_number = ?
                ORDER BY i.amount_outstanding";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $PaymentTransactionNumber );
        $PaymentTransactionNumber = $inPaymentTransactionNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rInvoiceNumber, $rCreationDate, $rInitialAmount, $rAmountOutstanding, $rWriteOffAmount, $rCustomerId, $rCreditOrderId );
        $Invoices = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            array_push( $Invoices, $rInvoiceNumber, $rCreationDate, $rInitialAmount, $rAmountOutstanding, $rWriteOffAmount, $rCustomerId, $rCreditOrderId );
        }

        mysqli_stmt_close( $Stmt );

        return $Invoices;
    }

/*********************************************************************
        $InvoicesTable = mysqli_query( $inConnection,
                                       "SELECT i.invoice_number, i.creation_date, i.initial_amount, i.amount_outstanding, i.write_off_amount, i.customer_id, i.credit_order_id
                                        FROM {$this->Prefix}payment_transaction_invoice pti, {$this->Prefix}invoice i
                                        WHERE pti.invoice_number = i.invoice_number AND
                                              pti.payment_transaction_number = {$inPaymentTransactionNumber}
                                        ORDER BY i.amount_outstanding" ) or die( mysqli_error( $inConnection ) );
        $Invoices = array();
        while( $Row = mysqli_fetch_assoc( $InvoicesTable ) )
        {
            $InvoiceDetails = array();
            $InvoiceDetails['invoice_number'] = $Row['invoice_number'];
            $InvoiceDetails['creation_date'] = $Row['creation_date'];
            $InvoiceDetails['initial_amount'] = $Row['initial_amount'];
            $InvoiceDetails['amount_outstanding'] = $Row['amount_outstanding'];
            $InvoiceDetails['write_off_amount'] = $Row['write_off_amount'];
            $InvoiceDetails['customer_id'] = $Row['customer_id'];
            $InvoiceDetails['credit_order_id'] = $Row['credit_order_id'];
            array_push( $Invoices, $InvoiceDetails );
        }
        mysqli_data_seek( $InvoicesTable, 0 );
*********************************************************************/

/*
SELECT i.invoice_number, i.creation_date, i.initial_amount, i.amount_outstanding, i.write_off_amount, i.customer_id, i.credit_order_id
FROM payment_transaction_invoice pti, invoice i
WHERE pti.invoice_number = i.invoice_number AND
      pti.payment_transaction_number = 3
ORDER BY i.amount_outstanding;

*/

//####################################################################




































//####################################################################
}
//####################################################################
?>
