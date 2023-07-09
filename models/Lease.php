<?php
//####################################################################
// Lease( CompanyId, AppId, StartDateTime, EndDateTime, LeasePrice )
//####################################################################
class Lease
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
    // Insert. Inserts a lease into the lease table.

    public function Insert( $inConnection, $inCompanyId, $inAppId, $inStartDateTime, $inEndDateTime, $inLeasePrice )
    {
        $Sql = "INSERT INTO {$this->Prefix}company( company_id, app_Id, start_date_time, end_date_time, lease_price )
                VALUES ( ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iissd", $CompanyId, $AppId, $StartDateTime, $EndDateTime, $LeasePrice );

        $CompanyId = $inCompanyId;
        $AppId = $inAppId;
        $StartDateTime = $inStartDateTime;
        $EndDateTime = $inEndDateTime;
        $LeasePrice = $inLeasePrice;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
    // IsLeasing. Returns true if the company identified by $inCompanyId is currently leasing the app with $inAppPath.

    public function IsLeasing( $inConnection, $inCompanyId, $inAppPath )
    {
        $Sql = "SELECT l.company_id, l.app_id, l.start_date_time, l.end_date_time
                FROM lease l, app a
                WHERE a.app_path = ? AND
                      l.company_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "si", $AppPath, $CompanyId );
        $AppPath = $inAppPath;
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCompanyId, $rAppId, $rStartDateTime, $rAppPath );
        $LeaseDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $LeaseDetails['company_id'] = $rCompanyId;
            $LeaseDetails['app_id'] = $rAppId;
            $LeaseDetails['start_date_time'] = $rStartDateTime;
            $LeaseDetails['end_date_time'] = $rEndDateTime;
        }

        mysqli_stmt_close( $Stmt );

        return count( $LeaseDetails ) > 0;

/**************************************************
        $LeaseDetails = array();
        while( $Row = mysql_fetch_assoc( $LeaseDetailsTable ) )
        {
            $LeaseDetails['company_id'] = $Row['company_id'];
            $LeaseDetails['app_id'] = $Row['app_id'];
            $LeaseDetails['start_date_time'] = $Row['start_date_time'];
            $LeaseDetails['end_date_time'] = $Row['end_date_time'];
        }

        return count( $LeaseDetails ) > 0;
**************************************************/
    }
/*
SELECT l.company_id, l.app_id, l.start_date_time, l.end_date_time
FROM lease l, app a
WHERE a.app_path = '{$inAppPath}';

*/

//####################################################################
}
































//####################################################################
?>
