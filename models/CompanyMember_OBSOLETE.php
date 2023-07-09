<?php
//####################################################################
// CompanyMember( MemberId(PK, FK ref:Member), CompanyName(PK, FK ref:Company) )
//####################################################################
class CompanyMember
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
    // Insert. Inserts a company-member relationship into the CompanyMember table.

    public function Insert( $inConnection, $inMemberId, $inCompanyId )
    {
/**************************************
        $Sql = "INSERT INTO {$this->Prefix}company( company_id, company_name )
                VALUES ( ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "is", $CompanyId, $CompanyName );

        $CompanyId = $inCompanyId;
        $CompanyName = $inCompanyName;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
***************************************/
        $Query = "INSERT INTO {$this->Prefix}company_member( member_id, company_id )
                  VALUES ( '{$inMemberId}', '{$inCompanyId}' )";
        mysqli_query( $inConnection, $Query );
    }

//====================================================================
    // GetMembers. Returns the members which are on the given company's team.

    public function GetMembers( $inConnection, $inCompanyName )
    {
    }

//====================================================================
    // GetCompanies. Returns the companies for which the given member is currently working.

    public function GetCompanies( $inConnection, $inMemberId )
    {
    }

//====================================================================
}
//####################################################################
?>
