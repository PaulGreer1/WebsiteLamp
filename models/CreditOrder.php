<?php
//####################################################################
// CreditOrder( CreditOrderId, TotalPrice, CreationDate, CustomerId )
//####################################################################
class CreditOrder
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
    // Insert. Inserts a credit order into the credit_order table.

    public function Insert( $inConnection, $inCreditOrderId, $inTotalPrice, $inCreationDate, $inCustomerId )
    {
        $Sql = "INSERT INTO {$this->Prefix}credit_order( credit_order_id, total_price, creation_date, customer_id )
                VALUES ( ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "idsi", $CreditOrderId, $TotalPrice, $CreationDate, $CustomerId );

        $CreditOrderId = $inCreditOrderId;
        $TotalPrice = $inTotalPrice;
        $CreationDate = $inCreationDate;
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );

/*********************************************************************
        $Query = "INSERT INTO {$this->Prefix}credit_order( credit_order_id, total_price, creation_date, customer_id )
                  VALUES ( '{$inCreditOrderId}', '{$inTotalPrice}', '{$inCreationDate}', '{$inCustomerId}' )";
		mysqli_query( $inConnection, $Query );
*********************************************************************/
    }

//####################################################################
	// DeleteCreditOrder.

	public function DeleteCreditOrder( $inConnection, $inInvoiceNumber )
	{
        $Sql = "DELETE
                FROM {$this->Prefix}credit_order
                WHERE credit_order_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );
        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
	}

/*****************************************
DELETE
FROM credit_order
WHERE credit_order_id = ( SELECT credit_order_id
                          FROM invoice i, credit_order co
                          WHERE i.credit_order_id = co.credit_order_id AND
                                i.invoice_number = {$inInvoiceNumber} );

        $Sql = "DELETE
                FROM credit_order
                WHERE credit_order_id IN ( SELECT co.credit_order_id
                                           FROM invoice i, credit_order co
                                           WHERE i.credit_order_id = co.credit_order_id AND
                                                 i.invoice_number = ? )";

SELECT co.credit_order_id
FROM invoice i, credit_order co
WHERE i.credit_order_id = co.credit_order_id AND
      i.invoice_number = 1;

*****************************************/

//####################################################################
    // GetCreditOrder. Returns the credit order with the given credit order id.

    public function GetCreditOrder( $inConnection, $inCreditOrderId )
    {
/*********************************************************************
        $Sql = "SELECT *
                FROM {$this->Prefix}credit_order
                WHERE credit_order_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CreditOrderId );
        $CreditOrderId = $inCreditOrderId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCreditOrderId, $rTotalPrice, $rCreationDate, $rCustomerId );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $CreditOrderTable below.
*********************************************************************/

        $CreditOrderTable = mysqli_query( $inConnection,
                                         "SELECT *
                                          FROM {$this->Prefix}credit_order
                                          WHERE credit_order_id = {$inCreditOrderId}" );
        return $CreditOrderTable;
    }

//####################################################################
    // HasCreditOrders. Returns true if the customer has any credit orders.

    public function HasCreditOrders( $inConnection, $inCustomerId )
    {
        $Sql = "SELECT *
                FROM {$this->Prefix}credit_order
                WHERE customer_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CustomerId );
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCreditOrderId, $rTotalPrice, $rCreationDate, $rCustomerId );
        $CreditOrders = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $CreditOrders['credit_order_id'] = $rCreditOrderId;
            $CreditOrders['total_price'] = $rTotalPrice;
            $CreditOrders['creation_date'] = $rCreationDate;
            $CreditOrders['customer_id'] = $rCustomerId;
        }

        mysqli_stmt_close( $Stmt );

        return count( $CreditOrders ) > 0;
    }

/*********************************************************************
        $CreditOrdersTable = mysqli_query( $inConnection,
                                           "SELECT *
                                            FROM {$this->Prefix}credit_order
                                            WHERE customer_id = {$inCustomerId}" );

        return mysqli_num_rows( $CreditOrdersTable ) > 0;
*********************************************************************/

//####################################################################
    // GetAllCreditOrders. Returns a table of all credit orders.

    public function GetAllCreditOrders( $inConnection )
    {
        $AllCreditOrdersTable = mysqli_query( $inConnection,
                                              "SELECT *
                                               FROM {$this->Prefix}credit_order" );
        return $AllCreditOrdersTable;
    }

//####################################################################
}

































































//####################################################################
?>
