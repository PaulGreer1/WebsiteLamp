<?php
//####################################################################
// Statement( StatementNumber, CreationDate, DaysUntilDue, LastDateChecked, CustomerId )
//####################################################################
class Statement
{
//====================================================================
    public $Registrar;
    public $Prefix;
//====================================================================
    // Constructor

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;
        $this->Prefix = $this->Registrar->Get('Config')->DBPrefix;
    }

//####################################################################
    // Insert. Inserts a statement into the Statement table. NOTE: The DaysUntilDue attribute is redundant.

    public function Insert( $inConnection, $inStatementNumber, $inCreationDate, $inDaysUntilDue, $inLastDateChecked, $inCustomerId  )
    {
        $Sql = "INSERT INTO {$this->Prefix}statement( statement_number, creation_date, days_until_due, last_date_checked, customer_id )
                VALUES ( ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "isisi", $StatementNumber, $CreationDate, $DaysUntilDue, $LastDateChecked, $CustomerId );

        $StatementNumber = $inStatementNumber;
        $CreationDate = $inCreationDate;
        $DaysUntilDue = $inDaysUntilDue;
        $LastDateChecked = $inLastDateChecked;
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $Query = "INSERT INTO {$this->Prefix}statement( statement_number, creation_date, days_until_due, last_date_checked, customer_id )
                    VALUES ( '{$inStatementNumber}', '{$inCreationDate}', '{$inDaysUntilDue}', '{$inLastDateChecked}', '{$inCustomerId}' )";

        mysqli_query( $inConnection, $Query ) or die( mysqli_error( $inConnection ) );
*********************************************************************/
    }

//####################################################################
    // GetStatement. Returns the statement with the given statement number.

    public function GetStatement( $inConnection, $inStatementNumber  )
    {
/*********************************************************************
        $Sql = "SELECT *
                FROM {$this->Prefix}statement
                WHERE statement_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $StatementNumber );
        $StatementNumber = $inStatementNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStatementNumber, $rCreationDate, $rDaysUntilDue, $rLastDateChecked, $rCustomerId );
        mysqli_stmt_close( $Stmt );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $CreditOrderTable below.

*********************************************************************/
        $StatementTable = mysqli_query( $inConnection,
                                        "SELECT *
                                         FROM {$this->Prefix}statement
                                         WHERE statement_number = {$inStatementNumber}" );
        return $StatementTable;
    }

//####################################################################
    // GetStatementByCustomerYearMonth. Returns the statement with the given customer id, year and month. NOTE: The DaysUntilDue attribute is redundant.

    public function GetStatementByCustomerYearMonth( $inConnection, $inCustomerId, $inYear, $inMonth  )
    {
        $Sql = "SELECT statement_number, creation_date, days_until_due, last_date_checked, customer_id
                FROM {$this->Prefix}statement
                WHERE customer_id = ? AND
                      YEAR( creation_date ) = ? AND
                      MONTH( creation_date ) = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CustomerId, $Year, $Month );
        $CustomerId = $inCustomerId;
        $Year = $inYear;
        $Month = $inMonth;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStatementNumber, $rCreationDate, $rDaysUntilDue, $rLastDateChecked, $rCustomerId );
        $Statement = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
           $Statement['statement_number'] = $rStatementNumber;
           $Statement['creation_date'] = $rCreationDate;
           $Statement['days_until_due'] = $rDaysUntilDue;
           $Statement['last_date_checked'] = $rLastDateChecked;
           $Statement['customer_id'] = $rCustomerId;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $StatementTable = mysqli_query( $inConnection,
                                        "SELECT statement_number, creation_date, days_until_due, last_date_checked, customer_id
                                         FROM {$this->Prefix}statement
                                         WHERE customer_id = {$inCustomerId} AND
                                               YEAR( creation_date ) = {$inYear} AND
                                               MONTH( creation_date ) = {$inMonth}" );
        $Statement = array();
        while( $Row = mysqli_fetch_assoc( $StatementTable ) )
        {
           $Statement['statement_number'] = $Row['statement_number'];
           $Statement['creation_date'] = $Row['creation_date'];
           $Statement['days_until_due'] = $Row['days_until_due'];
           $Statement['last_date_checked'] = $Row['last_date_checked'];
           $Statement['customer_id'] = $Row['customer_id'];
        }
        mysqli_data_seek( $StatementTable, 0 );
*********************************************************************/

        return $Statement;
    }

//####################################################################
    // GetAllStatements. Returns a table of all statements.

    public function GetAllStatements( $inConnection )
    {
        $AllStatementsTable = mysqli_query( $inConnection,
                                          "SELECT *
                                           FROM {$this->Prefix}statement" );
        return $AllStatementsTable;
    }

//####################################################################
    // GetStatements. Returns an array of all statements.

    public function GetStatements( $inConnection )
    {
        $StatementsTable = mysqli_query( $inConnection,
                                         "SELECT statement_number, creation_date, days_until_due, last_date_checked, customer_id
                                          FROM {$this->Prefix}statement" );
        $Statements = array();
        while( $Row = mysqli_fetch_assoc( $StatementsTable ) )
        {
            $Statement = array();
            $Statement['statement_number'] = $Row['statement_number'];
            $Statement['creation_date'] = $Row['creation_date'];
            $Statement['days_until_due'] = $Row['days_until_due'];
            $Statement['last_date_checked'] = $Row['last_date_checked'];
            $Statement['customer_id'] = $Row['customer_id'];
            array_push( $Statements, $Statement );
        }

        return $Statements;
    }

//####################################################################
    // GetStatementsByCompanyId. Returns the set of statements for the given company id.

    public function GetStatementsByCompanyId( $inConnection, $inCompanyId  )
    {
        $Sql = "SELECT s.statement_number, s.creation_date, s.days_until_due, s.last_date_checked, s.customer_id
                FROM statement s, customer cu, company co
                WHERE s.customer_id = cu.customer_id AND
                      cu.company_id = co.company_id AND
                      cu.company_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CompanyId );
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStatementNumber, $rCreationDate, $rDaysUntilDue, $rLastDateChecked, $rCustomerId );
        $Statements = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $Statement = array();
            $Statement['statement_number'] = $rStatementNumber;
            $Statement['creation_date'] = $rCreationDate;
            $Statement['days_until_due'] = $rDaysUntilDue;
            $Statement['last_date_checked'] = $rLastDateChecked;
            $Statement['customer_id'] = $rCustomerId;
            array_push( $Statements, $Statement );
        }

        mysqli_stmt_close( $Stmt );

        return $Statements;
    }

//####################################################################
    // Exists. Returns true if there exists a statement with the given customer id, year and month, otherwise returns false.

    public function Exists( $inConnection, $inCustomerId, $inDate )
    {
        $Exists = 0;                                              // FALSE

        $Sql = "SELECT *
                FROM {$this->Prefix}statement
                WHERE customer_id = ? AND
                      YEAR( creation_date ) = YEAR( ? ) AND
                      MONTH( creation_date ) = MONTH( ? )";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iss", $CustomerId, $Date, $Date );
        $CustomerId = $inCustomerId;
        $Date = $inDate;
        $Month = $inMonth;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStatementNumber, $rCreationDate, $rDaysUntilDue, $rLastDateChecked, $rCustomerId );
        $Statement = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
           $Statement['statement_number'] = $rStatementNumber;
           $Statement['creation_date'] = $rCreationDate;
           $Statement['days_until_due'] = $rDaysUntilDue;
           $Statement['last_date_checked'] = $rLastDateChecked;
           $Statement['customer_id'] = $rCustomerId;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $AllStatementsTable = mysqli_query( $inConnection,
                                            "SELECT *
                                             FROM statement
                                             WHERE customer_id = {$inCustomerId} AND
                                                   YEAR( creation_date ) = YEAR( {$inDate} ) AND
                                                   MONTH( creation_date ) = MONTH( {$inDate} )" );

        if( mysqli_num_rows( $AllStatementsTable ) > 0 )
        {
            $Exists = 1;                                  // TRUE
        }

        //return $Exists;
*********************************************************************/

        return count( $Statement ) > 0;
    }

//####################################################################
	// IsOverdue. Returns true if the month number in today's date [1] is greater than the month in $inDate [2] and $inAmount is greater than zero.
    // !!!!! ALERT !!!!! ENSURE THAT THE amount_outstanding PASSED IN INCLUDES THE amount_outstandings ON THE CURRENT MONTH'S
    // INVOICES...IF IT DOESN'T, THEN ORDERS MAY BE ACCEPTED EVEN WHEN .. ...

    public function IsOverdue( $inDate, $inAmount )
    {
        $Result = 0;
        $NewDate = date( "Y-m-d", strtotime( "+1 month", $inDate ) );

		//if( intval( date( "m", strtotime( date( 'Y-m-d' ) ) ) ) > intval( date( "m", strtotime( $inDate ) ) ) && $inAmount > 0 )
        if( round( ( strtotime( date('Y-m-d') ) - strtotime( $inDate ) ) / ( 60 * 60 * 24 ) ) > 0 && $inAmount > 0 )
		{
			$Result = 1;
		}

		return $Result;
    }

// I THINK THE FOLLOWING IS WRONG:
// !!!!! ALERT !!!!! (??? A statement is due by the last day of the month which follows the month on the statement's invoices. So I think you need to add
// a month to the month of $inDate, and test whether the month in the current date is greater than that. ???)
// [1] Get current date: https://stackoverflow.com/questions/2829120/mktime-php-date-timestamp-yyyy-mm-dd...Answer 1...
// [2] Find month number: https://stackoverflow.com/questions/3768072/php-date-function-to-get-month-of-the-date...Answer 2...

//####################################################################
	// GetLastDateChecked. Returns the date on which the statement identified by the attribute pair ( $inCustomer, $inCreationDate ) was last checked.

	public function GetLastDateChecked( $inConnection, $inCustomerId, $inCreationDate )
	{
        $Sql = "SELECT last_date_checked
                FROM {$this->Prefix}statement
                WHERE customer_id = ? AND
                      creation_date = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "is", $CustomerId, $CreationDate );
        $CustomerId = $inCustomerId;
        $CreationDate = $inCreationDate;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rLastDateChecked );
        $LastDateChecked = '';
        while( mysqli_stmt_fetch( $Stmt ) )
        {
           $LastDateChecked = $rLastDateChecked;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
		$LastDateCheckedTable = mysqli_query( $inConnection,
                                              "SELECT last_date_checked
                                               FROM statement
                                               WHERE customer_id = '{$inCustomerId}' AND
                                                     creation_date = '{$inCreationDate}'" );
		$LastDateChecked = '';
		while( $Row = mysqli_fetch_assoc( $LastDateCheckedTable ) )
		{
			$LastDateChecked = $Row['last_date_checked'];
		}
*********************************************************************/

		return date( 'Y-m-d', strtotime( $LastDateChecked ) );
	}

//####################################################################
	// SetLastDateChecked. Returns the date on which the statement identified by the attribute group ( $inCustomer, $inYear, $inMonth ) was last checked.

	public function SetLastDateChecked( $inConnection, $inDate, $inCustomerId, $inYear, $inMonth )
	{
        $Sql = "UPDATE {$this->Prefix}statement
                SET last_date_checked = ?
                WHERE customer_id = ? AND
                      YEAR( creation_date ) = ? AND
                      MONTH( creation_date ) = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "siss", $Date, $CustomerId, $Year, $Month );
        $Date = $inDate;
        $CustomerId = $inCustomerId;
        $Year = $inYear;
        $Month = $inMonth;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
/*********************************************************************
		mysqli_query( $inConnection,
                      "UPDATE statement
                       SET last_date_checked = {$inDate}
                       WHERE customer_id = '{$inCustomerId}' AND
                             YEAR( creation_date ) = '{$inYear}' AND
                             MONTH( creation_date ) = '{$inMonth}'" );
*********************************************************************/
	}

//####################################################################
/*
UPDATE statement SET last_date_checked = '2018-05-17' WHERE creation_date = '2018-05-01';
*/
}




























//####################################################################
?>
