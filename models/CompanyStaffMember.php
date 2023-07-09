<?php
//####################################################################
// CompanyStaffMember( StaffIdNumber(PK, FK ref:Company), CompanyId(PK, FK ref:Member) )
//####################################################################
class CompanyStaffMember
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
    // Insert. Inserts a company-staff_member relationship into the CompanyStaffMember table.

    public function Insert( $inConnection, $inStaffIdNumber, $inCompanyId )
    {
        $Sql = "INSERT INTO {$this->Prefix}company_staff_member( staff_id_number, company_id )
                VALUES ( ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $StaffIdNumber, $CompanyId );

        $StaffIdNumber = $inStaffIdNumber;
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
/**************************************
        $Query = "INSERT INTO {$this->Prefix}company_staff_member( staff_id_number, company_id )
                  VALUES ( '{$inStaffIdNumber}', '{$inCompanyId}' )";
        mysqli_query( $inConnection, $Query );
***************************************/
    }

//====================================================================
    // GetMembers. Returns the members which are on the given company's team.

    public function GetStaffMembers( $inConnection, $inCompanyName )
    {
    }

//====================================================================
    // GetCompanies. Returns the companies for which the given member is currently working.

    public function GetCustomers( $inConnection, $inStaffMemberId )
    {
    }

//====================================================================
}
//####################################################################
?>
