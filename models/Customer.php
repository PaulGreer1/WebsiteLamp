<?php
//####################################################################
// Customer( CustomerId(PK), ContactName, CompanyName, PhoneNumber, EmailAddress, AccountsEmailAddress, Address, VatNumber )
//####################################################################
class Customer
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
    // Insert. Inserts a customer into the Customer table.

    public function Insert( $inConnection, $inCustomerId, $inContactName, $inCompanyName, $inPhoneNumber, $inEmailAddress, $inAccountsEmailAddress, $inAddress, $inVatNumber, $inEmailAddress2, $inEmailAddress3, $inEmailAddress4, $inCompanyId )
    {
        $Sql = "INSERT INTO {$this->Prefix}customer( customer_id, contact_name, company_name, phone_number, email_address, accounts_email_address, address, vat_number, email_address_2, email_address_3, email_address_4, company_id )
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "issssssssssi", $CustomerId, $ContactName, $CompanyName, $PhoneNumber, $EmailAddress, $AccountsEmailAddress, $Address, $VatNumber, $EmailAddress2, $EmailAddress3, $EmailAddress4, $CompanyId );

        $CustomerId = $inCustomerId;
        $ContactName = $inContactName;
        $CompanyName = $inCompanyName;
        $PhoneNumber = $inPhoneNumber;
        $EmailAddress = $inEmailAddress;
        $AccountsEmailAddress = $inAccountsEmailAddress;
        $Address = $inAddress;
        $VatNumber = $inVatNumber;
        $EmailAddress2 = $inEmailAddress2;
        $EmailAddress3 = $inEmailAddress3;
        $EmailAddress4 = $inEmailAddress4;
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

/*******************************
        $Query = "INSERT INTO {$this->Prefix}customer( customer_id, contact_name, company_name, phone_number, email_address, accounts_email_address, address, vat_number, email_address_2, email_address_3, email_address_4, company_id )
                  VALUES ( '{$inCustomerId}', '{$inContactName}', '{$inCompanyName}', '{$inPhoneNumber}', '{$inEmailAddress}', '{$inAccountsEmailAddress}', '{$inAddress}', '{$inVatNumber}', '{$inEmailAddress2}', '{$inEmailAddress3}', '{$inEmailAddress4}', '{$inCompanyId}' )";

        mysqli_query( $inConnection, $Query );

*******************************/
//####################################################################
    // Update.

    public function Update( $inConnection, $inCustomerId, $inContactName, $inCompanyName, $inPhoneNumber, $inEmailAddress, $inAccountsEmailAddress, $inAddress, $inVatNumber )
    {
        $Sql = "UPDATE {$this->Prefix}customer
                SET customer_id = ?,
                    contact_name = ?,
                    company_name = ?,
                    phone_number = ?,
                    email_address = ?,
                    accounts_email_address = ?,
                    address = ?,
                    vat_number = ?
                WHERE customer_id = ?";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "issssssii", $CustomerId, $ContactName, $CompanyName, $PhoneNumber, $EmailAddress, $AccountsEmailAddress, $Address, $VatNumber, $CustomerId );

        $CustomerId = $inCustomerId;
        $ContactName = $inContactName;
        $CompanyName = $inCompanyName;
        $PhoneNumber = $inPhoneNumber;
        $EmailAddress = $inEmailAddress;
        $AccountsEmailAddress = $inAccountsEmailAddress;
        $Address = $inAddress;
        $VatNumber = $inVatNumber;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

/*********************************************************************
        $Query = "UPDATE {$this->Prefix}customer
                  SET customer_id = '{$inCustomerId}',
                      contact_name = '{$inContactName}',
                      company_name = '{$inCompanyName}',
                      phone_number = '{$inPhoneNumber}',
                      email_address = '{$inEmailAddress}',
                      accounts_email_address = '{$inAccountsEmailAddress}',
                      address = '{$inAddress}',
                      vat_number = '{$inVatNumber}'
                  WHERE customer_id = '{$inCustomerId}'";

        mysqli_query( $inConnection, $Query );
*********************************************************************/

//####################################################################
    // GetCustomer. Returns the customer with the given customer id.

    public function GetCustomer( $inConnection, $inCustomerId  )
    {
/*********************************************************************
        $Sql = "SELECT *
                FROM {$this->Prefix}customer
                WHERE customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CustomerId );
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCustomerId, $rContactName, $rCompanyName, $rPhoneNumber, $rEmailAddress, $rAccountsEmailAddress, $rAddress, $rVatNumber, $rEmailAddress2, $rEmailAddress3, $rEmailAddress4, $rCompanyId );
        mysqli_stmt_close( $Stmt );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $CreditOrderTable below.

*********************************************************************/
        $CustomerTable = mysqli_query( $inConnection,
                                       "SELECT *
                                        FROM {$this->Prefix}customer
                                        WHERE customer_id = {$inCustomerId}" );
        return $CustomerTable;
    }

//####################################################################
    // GetCustomerDetails. Returns an array of details for the customer with the given customer id.

    public function GetCustomerDetails( $inConnection, $inCustomerId  )
    {
        $Sql = "SELECT customer_id, contact_name, company_name, phone_number, email_address, accounts_email_address, address, vat_number, email_address_2, email_address_3, email_address_4, company_id
                FROM {$this->Prefix}customer
                WHERE customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CustomerId );
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCustomerId, $rContactName, $rCompanyName, $rPhoneNumber, $rEmailAddress, $rAccountsEmailAddress, $rAddress, $rVatNumber, $rEmailAddress2, $rEmailAddress3, $rEmailAddress4, $rCompanyId );
        $CustomerDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			$CustomerDetails['customer_id'] = $rCustomerId;
			$CustomerDetails['contact_name'] = $rContactName;
			$CustomerDetails['company_name'] = $rCompanyName;
			$CustomerDetails['phone_number'] = $rPhoneNumber;
			$CustomerDetails['email_address'] = $rEmailAddress;
			$CustomerDetails['accounts_email_address'] = $rAccountsEmailAddress;
			$CustomerDetails['address'] = $rAddress;
			$CustomerDetails['vat_number'] = $rVatNumber;
			$CustomerDetails['email_address_2'] = $rEmailAddress2;
			$CustomerDetails['email_address_3'] = $rEmailAddress3;
			$CustomerDetails['email_address_4'] = $rEmailAddress4;
			$CustomerDetails['company_id'] = $rCompanyId;
        }

        mysqli_stmt_close( $Stmt );

		return $CustomerDetails;
    }

/*********************************************************************
        $CustomerTable = mysqli_query( $inConnection,
                                       "SELECT customer_id, contact_name, company_name, phone_number, email_address, accounts_email_address, address, vat_number, email_address_2, email_address_3, email_address_4, company_id
                                        FROM {$this->Prefix}customer
                                        WHERE customer_id = {$inCustomerId}" );
		$CustomerDetails = array();
        while( $Row = mysqli_fetch_assoc( $CustomerTable ) )
		{
			$CustomerDetails['customer_id'] = $Row['customer_id'];
			$CustomerDetails['contact_name'] = $Row['contact_name'];
			$CustomerDetails['company_name'] = $Row['company_name'];
			$CustomerDetails['phone_number'] = $Row['phone_number'];
			$CustomerDetails['email_address'] = $Row['email_address'];
			$CustomerDetails['accounts_email_address'] = $Row['accounts_email_address'];
			$CustomerDetails['address'] = $Row['address'];
			$CustomerDetails['vat_number'] = $Row['vat_number'];
			$CustomerDetails['email_address_2'] = $Row['email_address_2'];
			$CustomerDetails['email_address_3'] = $Row['email_address_3'];
			$CustomerDetails['email_address_4'] = $Row['email_address_4'];
			$CustomerDetails['company_id'] = $Row['company_id'];
		}
*********************************************************************/
/*
SELECT customer_id, contact_name, company_name, phone_number, email_address, accounts_email_address, address, vat_number, email_address_2, email_address_3, email_address_4, company_id
FROM customer
WHERE customer_id = 1;

*/
//####################################################################
    // GetAllCustomers. Returns a table of all customers.

    public function GetAllCustomers( $inConnection )
    {
        $AllCustomersTable = mysqli_query( $inConnection,
                                           "SELECT *
                                            FROM {$this->Prefix}customer" );
        return $AllCustomersTable;
    }

//####################################################################
    // GetCustomersByCompanyId. Returns an array of customers of the company with the given company id.

	public function GetCustomersByCompanyId( $inConnection, $inCompanyId )
	{
        $Sql = "SELECT contact_name, company_name, customer_id
                FROM {$this->Prefix}customer
                WHERE company_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CompanyId );
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rContactName, $rCompanyName, $rCustomerId );
        $Customers = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			$Customer = array();
			$Customer['contact_name'] = $rContactName;
			$Customer['company_name'] = $rCompanyName;
			$Customer['customer_id'] = $rCustomerId;
			array_push( $Customers, $Customer );
        }

        mysqli_stmt_close( $Stmt );
		return $Customers;
	}

//####################################################################
	// GetCustomersByFilters. Returns an array of customers with each element holding details for a customer. If no matches are found for the input parameters, then a list of all customers is returned.
    // NOTE: In the SQL query, c.customer_id is compared with the $inCreditAccountNumber in-parameter. This is okay because the relationship between Customer and CreditAccount is one-to-one.

	//public function GetCustomersByFilters( $inConnection, $inCompanyName, $inCreditAccountNumber, $inEmailAddress )
	public function GetCustomersByFilters( $inConnection, $inCompanyName, $inCreditAccountNumber, $inEmailAddress, $inCompanyId )
	{
		$CustomersTable = 0;
        //##################################################
        $Sql = "SELECT c.contact_name, c.company_name, c.customer_id
                FROM {$this->Prefix}customer c
                WHERE ( c.company_name = ? OR
                        c.email_address = ? OR
                        c.customer_id = ? ) AND
                        c.company_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ssii", $CompanyName, $EmailAddress, $CreditAccountNumber, $CompanyId );
        $CompanyName = $inCompanyName;
        $EmailAddress = $inEmailAddress;
        $CreditAccountNumber = $inCreditAccountNumber;
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rContactName, $rCompanyName, $rCustomerId );
        $Customers = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
			$Customer = array();
			$Customer[0] = $rContactName;
			$Customer[1] = $rCompanyName;
			$Customer[2] = $rCustomerId;
			array_push( $Customers, $Customer );
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
		$CustomersTable = mysqli_query( $inConnection,
                                        "SELECT c.contact_name, c.company_name, c.customer_id
                                         FROM {$this->Prefix}customer c
                                         WHERE ( c.company_name = '{$inCompanyName}' OR
                                                 c.email_address = '{$inEmailAddress}' OR
                                                 c.customer_id = '{$inCreditAccountNumber}' ) AND
                                               c.company_id = '{$inCompanyId}'" );

		$Customers = array();
		while( $Row = mysqli_fetch_assoc( $CustomersTable ) )
		{
			$Customer = array();
			$Customer[0] = $Row['contact_name'];
			$Customer[1] = $Row['company_name'];
			$Customer[2] = $Row['customer_id'];
			array_push( $Customers, $Customer );
		}
*********************************************************************/

		return $Customers;
	}

/*****************************************************************
		$CreditAccountNumbersTable = mysqli_query( $inConnection,
                                                   "SELECT ca.credit_account_number
                                                    FROM {$this->Prefix}credit_account ca
                                                    WHERE ca.credit_account_number = '{$inCreditAccountNumber}' AND
                                                          c.company_id = '{$inCompanyId}'" );

		$CreditAccountNumbers = array();
		while( $Row = mysqli_fetch_assoc( $CreditAccountNumbersTable ) )
		{
			//array_push( $CreditAccountNumbers, $Row['credit_account_number'] );
            $CreditAccountNumbers['credit_account_number'] = $Row['credit_account_number'];
		}
        //##################################################
        $CreditAccountNumber = $CreditAccountNumbers['credit_account_number'];
		$CustomersTable2 = mysqli_query( $inConnection,
                                         "SELECT c.contact_name, c.company_name, c.customer_id
                                          FROM {$this->Prefix}customer c, {$this->Prefix}credit_account ca
                                          WHERE c.customer_id = ca.customer_id AND
                                                ca.credit_account_number = '{$CreditAccountNumber}' AND
                                                c.company_id = '{$inCompanyId}'" );

		while( $Row = mysqli_fetch_assoc( $CustomersTable2 ) )
		{
			$Customer = array();
			$Customer[0] = $Row['contact_name'];
			$Customer[1] = $Row['company_name'];
			$Customer[2] = $Row['customer_id'];
			array_push( $Customers, $Customer );
		}
*****************************************************************/
//####################################################################
}
//####################################################################
?>
