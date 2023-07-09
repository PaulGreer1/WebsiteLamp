<?php
//####################################################################
// PrivilegeMember( MemberId(PK, FK ref:Member), PrivilegeName(PK, FK ref:Privilege) )
//####################################################################
class PrivilegeMember
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
    // Insert. Inserts a privilege-member relationship into the PrivilegeMember table.

    public function Insert( $inConnection, $inMemberId, $inPrivilegeName )
    {
        $Query = "INSERT INTO {$this->Prefix}privilege_member( member_id, privilege_name )
                  VALUES ( '{$inMemberId}', '{$inPrivilegeName}' )";
        mysqli_query( $inConnection, $Query );
    }

//====================================================================
    // GetMembers. Returns the members which have the given privilege.

    public function GetMembers( $inConnection, $inPrivilegeName )
    {
    }

//====================================================================
    // GetPrivileges. Returns the privileges of the given member.

    public function GetPrivileges( $inConnection, $inMemberId )
    {
    }

//====================================================================
}
//####################################################################
?>
