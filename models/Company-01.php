<?php
//####################################################################
// Company( CompanyId, CompanyName, Address, Postcode )
//####################################################################
class Company
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
    // Insert. Inserts a company into the Company table.

    public function Insert( $inConnection, $inCompanyId, $inCompanyName, $inAddress = '', $inPostcode = '' )
    {
        $Sql = "INSERT INTO {$this->Prefix}company( company_id, company_name, address, postcode )
                VALUES ( ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "isss", $CompanyId, $CompanyName, $Address, $Postcode );

        $CompanyId = $inCompanyId;
        $CompanyName = $inCompanyName;
        $Address = $inAddress;
        $Postcode = $inPostcode;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

/*******************************
        $Query = "INSERT INTO {$this->Prefix}company( company_id, company_name )
                  VALUES ( '{$inCompanyId}', '{$inCompanyName}' )";

        mysqli_query( $inConnection, $Query );

*******************************/
//####################################################################
    // GetCompanyDetailsByCompanyName. Returns the details of the company with the given company name.

    public function GetCompanyDetailsByCompanyName( $inConnection, $inCompanyName )
    {
        $Sql = "SELECT company_id, company_name, address, postcode
                FROM {$this->Prefix}company
                WHERE company_name = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "s", $CompanyName );
        $CompanyName = $inCompanyName;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCompanyId, $rCompanyName, $rAddress, $rPostcode );
        $CompanyDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $CompanyDetails['company_id'] = $rCompanyId;
            $CompanyDetails['company_name'] = $rCompanyName;
            $CompanyDetails['address'] = $rAddress;
            $CompanyDetails['postcode'] = $rPostcode;
        }

        mysqli_stmt_close( $Stmt );

        return $CompanyDetails;
    }

/*********************************************************************
        $CompanyDetailsTable = mysqli_query( $inConnection,
                                             "SELECT company_id, company_name
                                              FROM {$this->Prefix}company
                                              WHERE company_name = '{$inCompanyName}'" );
        $CompanyDetails = array();
        while( $Row = mysqli_fetch_assoc( $CompanyDetailsTable ) )
        {
            $CompanyDetails['company_id'] = $Row['company_id'];
            $CompanyDetails['company_name'] = $Row['company_name'];
        }
        mysqli_data_seek( $CompanyDetailsTable, 0 );

        return $CompanyDetails;
*********************************************************************/

//####################################################################
    // GetCompanyDetailsByCompanyId. Returns the details of the company with the given company id.

    public function GetCompanyDetailsByCompanyId( $inConnection, $inCompanyId )
    {
        $Sql = "SELECT company_id, company_name, address, postcode
                FROM {$this->Prefix}company
                WHERE company_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CompanyId );
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCompanyId, $rCompanyName, $rAddress, $rPostcode );
        $CompanyDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $CompanyDetails['company_id'] = $rCompanyId;
            $CompanyDetails['company_name'] = $rCompanyName;
            $CompanyDetails['address'] = $rAddress;
            $CompanyDetails['postcode'] = $rPostcode;
        }

        mysqli_stmt_close( $Stmt );

        return $CompanyDetails;
    }

//####################################################################
    // GetCompany. Returns the company with the given company name.

    public function GetCompany( $inConnection, $inCompanyName  )
    {
/*********************************************************************
        $Sql = "SELECT company_id, company_name
                FROM {$this->Prefix}company
                WHERE company_name = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "s", $CompanyName );
        $CompanyName = $inCompanyName;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCompanyId, $rCompanyName );
        mysqli_stmt_close( $Stmt );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $CreditOrderTable below.

*********************************************************************/
        $CompanyTable = mysqli_query( $inConnection,
                                      "SELECT company_id, company_name, address, postcode
                                       FROM {$this->Prefix}company
                                       WHERE company_name = {$inCompanyName}" );
        return $CompanyTable;
    }

//####################################################################
//    // GetCompanies. Returns the details of every company (site customer).
//
//    public function GetCompanies( $inConnection )
//    {
//        $Sql = "SELECT company_id, company_name
//                FROM {$this->Prefix}company";
////        $Stmt = mysqli_prepare( $inConnection, $Sql );
//
////        mysqli_stmt_execute( $Stmt );
//
////        mysqli_stmt_bind_result( $Stmt, $rCompanyId, $rCompanyName );
//        $CompaniesDetails = array();
//        while( mysqli_stmt_fetch( $Stmt ) )
//        {
//            $Company = array();
//            $Company['company_id'] = $rCompanyId;
//            $Company['company_name'] = $rCompanyName;
//        }
//
//        mysqli_stmt_close( $Stmt );
////echo $CompaniesDetails['company_name'] . '<br />';
//        return $CompaniesDetails;
//    }
//
//####################################################################
    // GetCompanies. Returns the details of every company (site customer).

    public function GetCompanies( $inConnection )
    {
        $CompaniesDetailsTable = mysqli_query( $inConnection,
                                               "SELECT company_id, company_name, address, postcode
                                                FROM {$this->Prefix}company" );
        $CompaniesDetails = array();
        while( $Row = mysqli_fetch_assoc( $CompaniesDetailsTable ) )
        {
            $Company = array();
            $Company['company_id'] = $Row['company_id'];
            $Company['company_name'] = $Row['company_name'];
            $Company['address'] = $Row['address'];
            $Company['postcode'] = $Row['postcode'];
            array_push( $CompaniesDetails, $Company );
        }

        return $CompaniesDetails;
    }

//####################################################################
}
//####################################################################
?>
