<?php
//####################################################################
// Category( CategoryId, CategoryName, Description, Image, ParentCategoryId )
//####################################################################
class Category
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
    // Insert. Inserts a category into the category table.

    public function Insert( $inConnection, $inCategoryId, $inCategoryName, $inDescription = '', $inImage = '', $inParentCategoryId )
    {
        $Sql = "INSERT INTO {$this->Prefix}company( category_id, category_name, description, image, parent_category_id )
                VALUES ( ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "isssi", $CategoryId, $CategoryName, $Description, $Image, $ParentCategoryId );

        $CategoryId = $inCategoryId;
        $CategoryName = $inCategoryName;
        $Description = $inDescription;
        $Image = $inImage;
        $ParentCategoryId = $inParentCategoryId;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
    // GetChildCategories. Returns the child categories contained in the category identified by $inCategoryId.

    public function GetChildCategories( $inConnection, $inCategoryId )
    {
        $Sql = "SELECT category_id, category_name, description, image
                FROM category
                WHERE parent_category_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CategoryId );
        $CategoryId = $inCategoryId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCategoryId, $rCategoryName, $rDescription, $rImage );
        $Categories = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $CategoryDetails = array();
            $CategoryDetails['category_id'] = $rCategoryId;
            $CategoryDetails['category_name'] = $rCategoryName;
            $CategoryDetails['description'] = $rDescription;
            $CategoryDetails['image'] = $rImage;
            array_push( $Categories, $CategoryDetails );
        }

        mysqli_stmt_close( $Stmt );

        return $Categories;
    }

//####################################################################
    // GetNumberOfApps. Returns the number of apps contained in the category identified by $inCategoryId.

    public function GetNumberOfApps( $inConnection, $inCategoryId )
    {
        $Sql = "SELECT COUNT(*) AS app_count
                FROM app_category
                WHERE category_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CategoryId );
        $CategoryId = $inCategoryId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rAppCount );
        mysqli_stmt_fetch( $Stmt );

        mysqli_stmt_close( $Stmt );

        return $rAppCount;
    }

/***********
SELECT COUNT(*) AS app_count
FROM app_category
WHERE category_id = 5;

***********/

//####################################################################
    // GetCategoryDetails. Returns details about the category identified by the given category ID.

    public function GetCategoryDetails( $inConnection, $inCategoryId )
    {
        $Sql = "SELECT category_name, description, image
                FROM category
                WHERE category_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CategoryId );
        $CategoryId = $inCategoryId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCategoryName, $rDescription, $rImage );
        $CategoryDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $CategoryDetails['category_name'] = $rCategoryName;
            $CategoryDetails['description'] = $rDescription;
            $CategoryDetails['image'] = $rImage;
        }

        mysqli_stmt_close( $Stmt );

        return $CategoryDetails;
    }

//####################################################################
}

/*
// Find the number of apps in a category:
SELECT COUNT(*) AS app_count
FROM app_category
WHERE category_id = ?;

// Find the number of child categories in a category:
SELECT COUNT(*)
FROM category
WHERE parent_category_id = ?;

*/




























//####################################################################
?>
