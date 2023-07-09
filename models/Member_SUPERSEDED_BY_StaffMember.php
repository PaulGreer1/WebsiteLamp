<?php
//####################################################################
// Member( MemberId(PK), MemberName, EncryptedPassword, EmailAddress, MemberTypeBinaryCode, Status )
//####################################################################
class Member
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
    // Insert. Inserts a member into the Member table.

    public function Insert( $inConnection, $inMemberId, $inMemberName, $inEncryptedPassword, $inEmailAddress, $inMemberTypeBinaryCode, $inStatus )
    {
        $Sql = "INSERT INTO {$this->Prefix}member( member_id, member_name, encrypted_password, email_address, member_type_binary_code, status )
                VALUES ( ?, ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "isssss", $MemberId, $MemberName, $EncryptedPassword, $EmailAddress, $MemberTypeBinaryCode, $Status );

        $MemberId = $inMemberId;
        $MemberName = $inMemberName;
        $EncryptedPassword = $inEncryptedPassword;
        $EmailAddress = $inEmailAddress;
        $MemberTypeBinaryCode = $inMemberTypeBinaryCode;
        $Status = $inStatus;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
/**************************************
        $Query = "INSERT INTO {$this->Prefix}member( member_id, member_name, encrypted_password, email_address, member_type_binary_code, status )
                  VALUES ( '{$inMemberId}', '{$inMemberName}', '{$inEncryptedPassword}', '{$inEmailAddress}', '{$inMemberTypeBinaryCode}', '{$inStatus}' )";

        mysqli_query( $inConnection, $Query );
***************************************/
    }

//====================================================================
    // GetMembers. Returns a table of all members.

    public function GetAllMembers( $inConnection )
    {
        $AllMembersTable = mysqli_query( $inConnection,
                                         "SELECT member_id, member_name, encrypted_password, email_address, member_type_binary_code, status
                                          FROM {$this->Prefix}member" );
        return $AllMembersTable;
    }

//====================================================================
    // VerifyUser. Verifies that the user with the given password is a member.

    public function VerifyUser( $inConnection, $inAllMembersTable, $inPassword  )
    {
        $Result = 0;
        while( $row = mysqli_fetch_array( $inAllMembersTable ) )
        {
            if( crypt( $inPassword, $row['encrypted_password'] ) == $row['encrypted_password'] )
            {
                $Result = true;
                break;
            }
        }
        mysqli_data_seek( $inAllMembersTable, 0 );

        return $Result;
    }

//====================================================================
    // GetMember. Returns the member with the given member id.

    public function GetMember( $inConnection, $inMemberId  )
    {
        $MemberTable = mysqli_query( $inConnection,
                                     "SELECT member_id, member_name, encrypted_password, email_address, member_type_binary_code, status
                                      FROM {$this->Prefix}member
                                      WHERE member_id = {$inMemberId}" );
        return $MemberTable;
    }

//====================================================================
    // GetTaByCompanyName. Returns the TA of the company with the given company name. All TAs have member type binary code 0011, and each company has only one TA. Therefore we can use the given company name and member type binary code 0011 to pick out the TA we want.

    public function GetTaByCompanyName( $inConnection, $inCompanyName )
    {
        $TaDetailsTable = mysqli_query( $inConnection,
                                        "SELECT m.member_id, m.member_name, m.email_address, m.member_type_binary_code, m.status, c.company_name
                                         FROM {$this->Prefix}company c, {$this->Prefix}company_member cm, {$this->Prefix}member m
                                         WHERE c.company_id = cm.company_id AND
                                               cm.member_id = m.member_id AND
                                               c.company_name = '{$inCompanyName}' AND
                                               m.member_type_binary_code = '0011'" );
        $TaDetails = array();
        while( $Row = mysqli_fetch_assoc( $TaDetailsTable ) )
        {
            $TaDetails['member_id'] = $Row['member_id'];
            $TaDetails['member_name'] = $Row['member_name'];
            $TaDetails['email_address'] = $Row['email_address'];
            $TaDetails['member_type_binary_code'] = $Row['member_type_binary_code'];
            $TaDetails['status'] = $Row['status'];
            $TaDetails['company_name'] = $Row['company_name'];
        }
        mysqli_data_seek( $TaDetailsTable, 0 );

        return $TaDetails;
    }

/*
SELECT member_id, member_name, email_address, member_type_binary_code, status
FROM company c, company_member cm, member m
WHERE c.company_id = cm.company_id AND
      cm.member_id = m.member_id AND
      c.company_name = {$inCompanyName} AND
      m.member_type_binary_code = '0011'
*/

//====================================================================
    // EmailIsUniqueInTeam. Returns true if the given email address does not exist within the given team (company id).

    public function EmailIsUniqueInTeam( $inConnection, $inCompanyId, $inEmailAddress )
    {
        $MembersDetailsTable = mysqli_query( $inConnection,
                                             "SELECT c.company_id AS company_id
                                              FROM {$this->Prefix}company c, {$this->Prefix}company_member cm, {$this->Prefix}member m
                                              WHERE c.company_id = cm.company_id AND
                                                    cm.member_id = m.member_id AND
                                                    c.company_id = {$inCompanyId} AND
                                                    m.email_address = '{$inEmailAddress}'" );
        $MembersDetails = array();
        while( $Row = mysqli_fetch_assoc( $MembersDetailsTable ) )
        {
            $MembersDetails['company_id'] = $Row['company_id'];
        }
        mysqli_data_seek( $MembersDetailsTable, 0 );

        return ( mysqli_num_rows( $MembersDetailsTable ) > 0 );
    }

/*
SELECT *
FROM company c, company_member cm, member m
WHERE c.company_id = cm.company_id AND
      cm.member_id = m.member_id AND
      c.company_id = 000001 AND
      m.email_address = 'a@a.com';

*/

//====================================================================
}
//####################################################################
?>































