<?php
//####################################################################
// AppCategory( AppId, CategoryId )
//####################################################################
class AppCategory
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
    // Insert. Inserts an app category into the app_category table.

    public function Insert( $inConnection, $inAppId, $inCategoryId )
    {
        $Sql = "INSERT INTO {$this->Prefix}company( app_id, category_id )
                VALUES ( ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $AppId, $Category );

        $AppId = $inAppId;
        $Category = $inCategory;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
}
//####################################################################
?>
