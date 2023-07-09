<?php
//####################################################################
// App( AppId, AppName, AppDescription, AppPath, AppTypeBinaryCode, Price, VatRateId )
//####################################################################
class App
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
    // Insert. Inserts an app into the app table.

    public function Insert( $inConnection, $inAppId, $inAppName, $inAppDescription, $inAppPath, $inAppTypeBinaryCode, $inPrice, $inVatRateId )
    {
        $Sql = "INSERT INTO {$this->Prefix}company( app_id, app_name, app_description, app_path, app_type_binary_code, price, vat_rate_id )
                VALUES ( ?, ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "issssdi", $AppId, $AppName, $AppDescription, $AppPath, $AppTypeBinaryCode, $Price, $VatRateId );

        $inAppId = $inAppId;
        $inAppName = $inAppName;
        $inAppDescription = $inAppDescription;
        $inAppPath = $inAppPath;
        $inAppTypeBinaryCode = $inAppTypeBinaryCode;
        $inPrice = $inPrice;
        $inVatRateId = $inVatRateId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
    // IsAuthorised. Returns true if the staff member identified by $inStaffIdNumber is authorised to use the app with $inAppPath.

    public function IsAuthorised( $inConnection, $inStaffIdNumber, $inAppPath )
    {
        $Sql = "SELECT member_type_binary_code
                FROM staff_member
                WHERE staff_id_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $StaffIdNumber );
        $StaffIdNumber = $inStaffIdNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rMemberTypeBinaryCode );
        mysqli_stmt_fetch( $Stmt );
        $MTBC = $rMemberTypeBinaryCode;
//        $MTBC = "0001";

        mysqli_stmt_close( $Stmt );

        $Sql = "SELECT app_type_binary_code
                FROM app
                WHERE app_path = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "s", $AppPath );
        $AppPath = $inAppPath;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rAppTypeBinaryCode );
        mysqli_stmt_fetch( $Stmt );
        $ATBC = $rAppTypeBinaryCode;
//        $ATBC = "0010";

        mysqli_stmt_close( $Stmt );

        return (bool)( bindec( $ATBC ) & bindec( $MTBC ) );
    }

//####################################################################
    // Exists.

    public function Exists( $inConnection, $inTableName, $inColumnName, $inColumnValue )
    {
        $Table = mysqli_query( $inConnection,
                               "SELECT {$inColumnName} AS ColumValue
                                FROM {$this->Prefix}{$inTableName}
                                WHERE {$inColumnName} = '{$inColumnValue}'" );

        return ( mysqli_num_rows( $Table ) > 0 );
    }

//####################################################################
    // GetApps. Returns details of the apps contained in the category identified by $inCategoryId.

    public function GetApps( $inConnection, $inCategoryId )
    {
        $Sql = "SELECT a.app_id, a.app_name, a.app_description, a.price, ac.category_id
                FROM app a, app_category ac
                WHERE a.app_id = ac.app_id AND
                      ac.category_id = ? AND
                      a.price > 0.00";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CategoryId );
        $CategoryId = $inCategoryId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rAppId, $rAppName, $rAppDescription, $rPrice, $rCategoryId );
        $Apps = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $AppDetails = array();
            $AppDetails['app_id'] = $rAppId;
            $AppDetails['app_name'] = $rAppName;
            $AppDetails['app_description'] = $rAppDescription;
            $AppDetails['price'] = $rPrice;
            $AppDetails['category_id'] = $rCategoryId;
            array_push( $Apps, $AppDetails );
        }

        return $Apps;
    }

/*********************************
Apps <- SELECT a.app_name, a.app_description, a.price, ac.category_id         // Get the apps of inCatId. Category::GetApps( inCatId ).
        FROM app a, app_category ac
        WHERE a.app_id = ac.app_id AND
              ac.category_id = '{$inCatId}' AND
              a.price > 0.00
*********************************/

//####################################################################
}




















































//####################################################################
?>
