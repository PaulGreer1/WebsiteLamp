<?php
//####################################################################
// CustomerCompany( CustomerId(PK, FK refs Customer.CustomerId), CompanyId(PK, FK refs StaffMember.StaffIdNumber) )
//####################################################################
class CustomerCompany
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

//====================================================================
    // Insert. Inserts a customer-company relationship into the customer_company table.

    public function Insert( $inConnection, $inCustomerId, $inCompanyId )
    {
        $Sql = "INSERT INTO {$this->Prefix}customer_company( customer_id, company_id )
                VALUES ( ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "is", $CustomerId, $CompanyId );

        $CustomerId = $inCustomerId;
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
/**************************************
        $Query = "INSERT INTO {$this->Prefix}customer_company( customer_id, company_id )
                  VALUES ( '{$inCustomerId}', '{$inCompanyId}' )";
        mysqli_query( $inConnection, $Query );
***************************************/
    }

//====================================================================
}
//####################################################################
?>
