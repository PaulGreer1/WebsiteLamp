<?php
//####################################################################
// CreditAccount( CreditAccountNumber, CreationDate, CreditLimit, AmountOutstanding, CustomerId )
//####################################################################
class CreditAccount
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
    // Insert. Inserts a credit account into the credit_account table.

    public function Insert( $inConnection, $inCreditAccountNumber, $inCreationDate, $inCreditLimit, $inAmountOutstanding, $inCustomerId )
    {
        $Sql = "INSERT INTO {$this->Prefix}credit_account( credit_account_number, creation_date, credit_limit, amount_outstanding, customer_id )
                VALUES ( ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "isddi", $CreditAccountNumber, $CreationDate, $CreditLimit, $AmountOutstanding, $CustomerId );

        $CreditAccountNumber = $inCreditAccountNumber;
        $CreationDate = $inCreationDate;
        $CreditLimit = $inCreditLimit;
        $AmountOutstanding = $inAmountOutstanding;
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

/*********************************************************************
        $Query = "INSERT INTO {$this->Prefix}credit_account( credit_account_number, creation_date, credit_limit, amount_outstanding, customer_id )
                  VALUES ( '{$inCreditAccountNumber}', '{$inCreationDate}', '{$inCreditLimit}', '{$inAmountOutstanding}', '{$inCustomerId}' )";

		mysqli_query( $inConnection, $Query );

*********************************************************************/
//####################################################################
    // Update.

    public function Update( $inConnection, $inCreditLimit, $inCustomerId )
    {
        $Sql = "UPDATE {$this->Prefix}credit_account
                SET credit_limit = ?
                WHERE customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $CreditLimit, $CustomerId );
        $CreditLimit = $inCreditLimit;
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

/*********************************************************************
        $Query = "UPDATE {$this->Prefix}credit_account
                  SET credit_limit = '{$inCreditLimit}'
                  WHERE customer_id = '{$inCustomerId}'";

        mysqli_query( $inConnection, $Query );
*********************************************************************/

//####################################################################
    // GetCreditAccount. Returns the credit account with the given credit account number.

    public function GetCreditAccount( $inConnection, $inCreditAccountNumber  )
    {
/*********************************************************************
        $Sql = "SELECT *
                FROM {$this->Prefix}credit_account
                WHERE credit_account_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CreditAccountNumber );
        $CreditAccountNumber = $inCreditAccountNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCreditAccountNumber, $rCreationDate, $rCreditLimit, $rAmountOutstanding, $rCustomerId );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $CreditAccountTable below.

*********************************************************************/

        $CreditAccountTable = mysqli_query( $inConnection,
                                            "SELECT *
                                             FROM {$this->Prefix}credit_account
                                             WHERE credit_account_number = {$inCreditAccountNumber}" );
        return $CreditAccountTable;
    }

//####################################################################
    // GetCreditAccountByCustomerId. Returns and array holding the credit account details corresponding to the given customer id.

    public function GetCreditAccountByCustomerId( $inConnection, $inCustomerId  )
    {
        $Sql = "SELECT *
                FROM {$this->Prefix}credit_account
                WHERE customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CustomerId );
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCreditAccountNumber, $rCreationDate, $rCreditLimit, $rAmountOutstanding, $rCustomerId );
        $CreditAccount = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			$CreditAccount['credit_account_number'] = $rCreditAccountNumber;
			$CreditAccount['creation_date'] = $rCreationDate;
			$CreditAccount['credit_limit'] = $rCreditLimit;
			$CreditAccount['amount_outstanding'] = $rAmountOutstanding;
			$CreditAccount['customer_id'] = $rCustomerId;
        }

        mysqli_stmt_close( $Stmt );

        return $CreditAccount;
    }

/*********************************************************************
        $CreditAccountTable = mysqli_query( $inConnection,
                                            "SELECT *
                                             FROM {$this->Prefix}credit_account
                                             WHERE customer_id = {$inCustomerId}" );
		$CreditAccount = array();
		while( $Row = mysqli_fetch_assoc( $CreditAccountTable ) )
		{
			$CreditAccount['credit_account_number'] = $Row['credit_account_number'];
			$CreditAccount['creation_date'] = $Row['creation_date'];
			$CreditAccount['credit_limit'] = $Row['credit_limit'];
			$CreditAccount['amount_outstanding'] = $Row['amount_outstanding'];
			$CreditAccount['customer_id'] = $Row['customer_id'];
		}
*********************************************************************/

//####################################################################
    // GetAllCreditAccounts. Returns a table of all credit accounts.

    public function GetAllCreditAccounts( $inConnection )
    {
        $CreditAccountsTable = mysqli_query( $inConnection,
                                             "SELECT credit_account_number, creation_date, credit_limit, amount_outstanding, customer_id
                                              FROM {$this->Prefix}credit_account" );
        $CreditAccounts = array();
		while( $Row = mysqli_fetch_assoc( $CreditAccountsTable ) )
		{
            $CreditAccount = array();
			$CreditAccount['credit_account_number'] = $Row['credit_account_number'];
			$CreditAccount['creation_date'] = $Row['creation_date'];
			$CreditAccount['credit_limit'] = $Row['credit_limit'];
			$CreditAccount['amount_outstanding'] = $Row['amount_outstanding'];
			$CreditAccount['customer_id'] = $Row['customer_id'];
            array_push( $CreditAccounts, $CreditAccount );
		}

        return $CreditAccounts;
    }

//####################################################################
    // GetCreditAccountsByCustomerId. Returns and array of credit accounts corresponding to the given company id.

    public function GetCreditAccountsByCompanyId( $inConnection, $inCompanyId  )
    {
        $Sql = "SELECT *
                FROM {$this->Prefix}credit_account
                WHERE company_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CompanyId );
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCreditAccountNumber, $rCreationDate, $rCreditLimit, $rAmountOutstanding, $rCustomerId );
        $CreditAccounts = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			$CreditAccounts['credit_account_number'] = $rCreditAccountNumber;
			$CreditAccounts['creation_date'] = $rCreationDate;
			$CreditAccounts['credit_limit'] = $rCreditLimit;
			$CreditAccounts['amount_outstanding'] = $rAmountOutstanding;
			$CreditAccounts['customer_id'] = $rCustomerId;
        }

        mysqli_stmt_close( $Stmt );

        return $CreditAccounts;
    }

//####################################################################
}


















































//####################################################################
?>
