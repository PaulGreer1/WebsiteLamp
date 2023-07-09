<?php
//####################################################################
// StaffMemberApp( StaffIdNumber, AppId )
//####################################################################
class StaffMemberApp
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
    // Insert. Inserts a staff member app into the staff_member_app table.

    public function Insert( $inConnection, $inStaffIdNumber, $inAppId )
    {
        $Sql = "INSERT INTO {$this->Prefix}company( staff_id_number, app_id )
                VALUES ( ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $StaffIdNumber, $AppId );

        $StaffIdNumber = $inStaffIdNumber;
        $AppId = $inAppId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
}
//####################################################################
?>
