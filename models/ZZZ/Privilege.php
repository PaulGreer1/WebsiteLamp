<?php
//####################################################################
// Privilege( PrivilegeName(PK), PrivilegeDescription )
//####################################################################
class Company
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
    // Insert. Inserts a privilege into the Privilege table.

    public function Insert( $inConnection, $inPrivilegeName, $inPrivilegeDeccription )
    {
        $Query = "INSERT INTO {$this->Prefix}privilege( privilege_name, privilege_description )
                  VALUES ( '{$inPrivilegeName}', '{$inPrivilegeDescription}' )";
        mysqli_query( $Connection, $Query );
    }

//====================================================================
}
//####################################################################
?>
