<?php
//####################################################################
// InvoiceItem( QuoteId, ItemNumber, Description, Price, InvoiceNumber, CustomerId )
//####################################################################
class InvoiceItem
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
    // Insert. Inserts an invoice item into the InvoiceItem table.

    public function Insert( $inConnection, $inQuoteId, $inItemNumber, $inDescription, $inPrice, $inInvoiceNumber, $inCustomerId )
    {
        $Sql = "INSERT INTO {$this->Prefix}invoice_item( quote_id, item_number, description, price, invoice_number, customer_id )
                VALUES ( ?, ?, ?, ?, ?, ? )";
        //$Sql .= "( ?, ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iisdii", $QuoteId, $ItemNumber, $Description, $Price, $InvoiceNumber, $CustomerId );

        $QuoteId = $inQuoteId;
        $ItemNumber = $inItemNumber;
        $Description = $inDescription;
        $Price = $inPrice;
        $InvoiceNumber = $inInvoiceNumber;
        $CustomerId = $inCustomerId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
    // Delete. Deletes the quote with the given quote id.

    public function Delete( $inConnection, $inQuoteId )
    {
        $Sql = "DELETE
                FROM invoice_item
                WHERE quote_id = ?";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $QuoteId );

        $QuoteId = $inQuoteId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
    // DeleteQuoteByInvoiceNumber. Deletes the quote with the given invoice number.

    public function DeleteQuoteByInvoiceNumber( $inConnection, $inInvoiceNumber )
    {
        $Sql = "DELETE
                FROM invoice_item
                WHERE invoice_number = ?";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $InvoiceNumber );

        $InvoiceNumber = $inInvoiceNumber;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
    // Update. Updates the description and the price of the invoice item with the given quote id and item number.

    public function Update( $inConnection, $inDescription, $inPrice, $inQuoteId, $inItemNumber )
    {
        $Sql = "UPDATE invoice_item
                SET description = ?, price = ?
                WHERE quote_id = ? AND
                      item_number = ?";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "sdii", $Description, $Price, $QuoteId, $ItemNumber );

        $Description = $inDescription;
        $Price = $inPrice;
        $QuoteId = $inQuoteId;
        $ItemNumber = $inItemNumber;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

/*
UPDATE invoice_item
SET description = {$inDescription}, price = {$inPrice}
WHERE quote_id = {$inQuoteId} AND
      item_number = {$inItemNumber};

UPDATE Customers
SET ContactName = 'Alfred Schmidt', City = 'Frankfurt'
WHERE CustomerID = 1;

UPDATE invoice_item
SET description = 'asdf', price = 50.00
WHERE quote_id = 1 AND item_number = 1;

*/

/********************************************
UPDATE invoice_item
SET item_number = 1, description = 'asdf', price = 1.20
WHERE quote_id = 1;

********************************************/
/********************************************************
        mysqli_query( $inConnection, "UPDATE invoice_item
                                      SET description = '{$inDescription}', price = '{$inPrice}'
                                      WHERE quote_id = {$inQuoteId} AND
                                            item_number = {$inItemNumber}" );
********************************************************/
//####################################################################
    // ConvertQuoteToInvoice. Sets the invoice number of the invoice item with the given quote id, to the given invoice number.

    public function ConvertQuoteToInvoice( $inConnection, $inInvoiceNumber, $inQuoteId )
    {
        $Sql = "UPDATE invoice_item
                SET invoice_number = ?
                WHERE quote_id = ?";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $InvoiceNumber, $QuoteId );

        $InvoiceNumber = $inInvoiceNumber;
        $QuoteId = $inQuoteId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }


//####################################################################
    // GetQuoteByQuoteId. Returns the details of the set of invoice items with the given QuoteId - i.e. a quote.

    public function GetQuoteByQuoteId( $inConnection, $inQuoteId )
    {
        $Sql = "SELECT quote_id, item_number, description, price, invoice_number, customer_id
                FROM {$this->Prefix}invoice_item
                WHERE quote_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $QuoteId );
        $QuoteId = $inQuoteId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rQuoteId, $rItemNumber, $rDescription, $rPrice, $rInvoiceNumber, $rCustomerId );
        $InvoiceItemDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $InvoiceItem = array();
            $InvoiceItem['quote_id'] = $rQuoteId;
            $InvoiceItem['item_number'] = $rItemNumber;
            $InvoiceItem['description'] = $rDescription;
            $InvoiceItem['price'] = $rPrice;
            $InvoiceItem['invoice_number'] = $rInvoiceNumber;
            $InvoiceItem['customer_id'] = $rCustomerId;
            array_push( $InvoiceItemDetails, $InvoiceItem );
        }

        mysqli_stmt_close( $Stmt );

        return $InvoiceItemDetails;
    }

/*
SELECT quote_id, item_number, description, price, invoice_number, customer_id
FROM invoice_item
WHERE quote_id = 4;

*/

//####################################################################
    // GetInvoiceItemDetailsByQuoteIdItemNumber. Returns the details of the invoice item with the given ( QuoteId, ItemNumber ).

    public function GetInvoiceItemDetailsByQuoteIdItemNumber( $inConnection, $inQuoteId, $inItemNumber )
    {
        $Sql = "SELECT quote_id, item_number, description, price, invoice_number, customer_id
                FROM {$this->Prefix}invoice_item
                WHERE quote_id = ? AND
                      item_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $QuoteId, $ItemNumber );
        $QuoteId = $inQuoteId;
        $ItemNumber = $inItemNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rQuoteId, $rItemNumber, $rDescription, $rPrice, $rInvoiceNumber, $rCustomerId );
        $InvoiceItemDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $InvoiceItemDetails['quote_id'] = $rQuoteId;
            $InvoiceItemDetails['item_number'] = $rItemNumber;
            $InvoiceItemDetails['description'] = $rDescription;
            $InvoiceItemDetails['price'] = $rPrice;
            $InvoiceItemDetails['invoice_number'] = $rInvoiceNumber;
            $InvoiceItemDetails['customer_id'] = $rCustomerId;
        }

        mysqli_stmt_close( $Stmt );

        return $InvoiceItemDetails;
    }

//####################################################################
    // GetQuoteTotal. Returns the total of the quote with the given quote id.

    public function GetQuoteTotal( $inConnection, $inQuoteId )
    {
        $Sql = "SELECT SUM( price ) AS price
                FROM {$this->Prefix}invoice_item
                WHERE quote_id = ?
                GROUP BY quote_id";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $QuoteId );
        $QuoteId = $inQuoteId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rPrice );
        $InvoiceItemDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $InvoiceItemDetails['price'] = $rPrice;
        }

        mysqli_stmt_close( $Stmt );

        return $InvoiceItemDetails;
    }

/*
SELECT SUM( price ) AS price
FROM invoice_item
WHERE quote_id = 3
GROUP BY quote_id;

*/

//####################################################################
    // GetInvoiceItems. Returns the details of every invoice item.

    public function GetInvoiceItems( $inConnection )
    {
        $InvoiceItemsDetailsTable = mysqli_query( $inConnection,
                                                  "SELECT quote_id, item_number, description, price, invoice_number, customer_id
                                                   FROM {$this->Prefix}invoice_item" );
        $InvoiceItemDetails = array();
        while( $Row = mysqli_fetch_assoc( $InvoiceItemDetailsTable ) )
        {
            $InvoiceItem = array();
            $InvoiceItem['quote_id'] = $Row['quote_id'];
            $InvoiceItem['item_number'] = $Row['item_number'];
            $InvoiceItem['description'] = $Row['description'];
            $InvoiceItem['price'] = $Row['price'];
            $InvoiceItem['invoice_number'] = $Row['invoice_number'];
            $InvoiceItem['customer_id'] = $Row['customer_id'];
            array_push( $InvoiceItemDetails, $InvoiceItem );
        }

        return $InvoiceItemDetails;
    }

//####################################################################
    // GetQuotes. Returns the details of every invoice item with the given company id, and which is not linked to an invoice - i.e. where InvoiceNumber is NULL.

    public function GetQuotes( $inConnection, $inCompanyId )
    {
        $Sql = "SELECT it.quote_id, SUM( it.price ) AS price, it.customer_id, c.company_name, c.company_id
                FROM {$this->Prefix}invoice_item it, {$this->Prefix}customer c
                WHERE it.customer_id = c.customer_id AND
                      it.invoice_number IS NULL AND
                      c.company_id = ?
                GROUP BY quote_id";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CompanyId );
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rQuoteId, $rPrice, $rCustomerId, $rCompanyName, $rCompanyId );
        $QuotesDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $Quote = array();
            $Quote['quote_id'] = $rQuoteId;
            $Quote['price'] = $rPrice;
            $Quote['customer_id'] = $rCustomerId;
            $Quote['company_name'] = $rCompanyName;
            $Quote['company_id'] = $rCompanyId;
            array_push( $QuotesDetails, $Quote );
        }

        mysqli_stmt_close( $Stmt );

        return $QuotesDetails;
    }

/*********************************************************************
        $QuotesDetailsTable = mysqli_query( $inConnection,
                                            "SELECT it.quote_id, SUM( it.price ) AS price, it.customer_id, c.company_name, c.company_id
                                             FROM {$this->Prefix}invoice_item it, {$this->Prefix}customer c
                                             WHERE it.customer_id = c.customer_id AND
                                                   it.invoice_number IS NULL AND
                                                   c.company_id = $inCompanyId
                                             GROUP BY quote_id" );
        $QuotesDetails = array();
        while( $Row = mysqli_fetch_assoc( $QuotesDetailsTable ) )
        {
            $Quote = array();
            $Quote['quote_id'] = $Row['quote_id'];
            $Quote['price'] = $Row['price'];
            $Quote['customer_id'] = $Row['customer_id'];
            $Quote['company_name'] = $Row['company_name'];
            $Quote['company_id'] = $Row['company_id'];
            array_push( $QuotesDetails, $Quote );
        }

        return $QuotesDetails;
*********************************************************************/
/*
SELECT it.quote_id, SUM( it.price ) AS price, it.customer_id, c.company_name
FROM invoice_item it, customer c
WHERE it.customer_id = c.customer_id AND
      it.invoice_number IS NULL
GROUP BY quote_id;

*/

//####################################################################
    // GetQuoteIds. Returns all quote ids. Includes duplicates. Use array_unique to remove duplicates.

    public function GetQuoteIds( $inConnection )
    {
        $QuoteIdsTable = mysqli_query( $inConnection,
                                       "SELECT quote_id
                                        FROM {$this->Prefix}invoice_item" );
        $QuoteIds = array();
        while( $Row = mysqli_fetch_assoc( $QuoteIdsTable ) )
        {
            array_push( $QuoteIds, $Row['quote_id'] );
        }

        return $QuoteIds;
    }

//####################################################################
}
//####################################################################


















































?>
