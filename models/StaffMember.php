<?php
//####################################################################
// StaffMember( StaffIdNumber(PK), Username, Password, EmailAddress, StaffType )
//####################################################################
class StaffMember
{
//====================================================================
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
    // Insert. Inserts a member into the Member table.

    public function Insert( $inConnection, $inStaffIdNumber, $inUsername, $inPassword, $inEmailAddress, $inStaffType, $inIsActive, $inMemberTypeBinaryCode, $inStatus, $inPhoneNumber = '' )
    {
        $Sql = "INSERT INTO {$this->Prefix}staff_member( staff_id_number, username, password, email_address, staff_type, is_active, member_type_binary_code, status, phone_number )
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "issssisss", $StaffIdNumber, $Username, $Password, $EmailAddress, $StaffType, $IsActive, $MemberTypeBinaryCode, $Status, $PhoneNumber );

        $StaffIdNumber = $inStaffIdNumber;
        $Username = $inUsername;
        $Password = $inPassword;
        $EmailAddress = $inEmailAddress;
        $StaffType = $inStaffType;
        $IsActive = $inIsActive;
        $MemberTypeBinaryCode = $inMemberTypeBinaryCode;
        $Status = $inStatus;
        $PhoneNumber = $inPhoneNumber;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

/********************************************************************
        $Query = "INSERT INTO {$this->Prefix}staff_member( staff_id_number, username, password, email_address, staff_type, is_active, member_type_binary_code, status )
                  VALUES ( '{$inStaffIdNumber}', '{$inUsername}', '{$inPassword}', '{$inEmailAddress}', '{$inStaffType}', '{$inIsActive}', '{$inMemberTypeBinaryCode}', '{$inStatus}' )";

        mysqli_query( $inConnection, $Query );
********************************************************************/

//####################################################################
	// UpdateStaffMember.

	public function UpdateStaffMember( $inConnection, $inUsername, $inEncryptedPassword, $inEmailAddress, $inStaffIdNumber )
	{
        $Sql = "UPDATE {$this->Prefix}staff_member
                SET username = ?, password = ?, email_address = ?
                WHERE staff_id_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "sssi", $Username, $EncryptedPassword, $EmailAddress, $StaffIdNumber );
        $Username = $inUsername;
        $EncryptedPassword = $inEncryptedPassword;
        $EmailAddress = $inEmailAddress;
        $StaffIdNumber = $inStaffIdNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
/*********************************************************************
The following will be used when the system is updated to enable multiple TAs.

        $Sql = "UPDATE staff_member
                SET username = ?, password = ?, email_address = ?, staff_type = ?
                WHERE staff_id_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ssssi", $Username, $EncryptedPassword, $EmailAddress, $StaffType, $StaffIdNumber );
        $Username = $inUsername;
        $EncryptedPassword = $inEncryptedPassword;
        $EmailAddress = $inEmailAddress;
        $StaffType = $inStaffType;
        $StaffIdNumber = $inStaffIdNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
*********************************************************************/
	}

//####################################################################
	// ChangeStaffMemberStatus.

	public function ChangeStaffMemberStatus( $inConnection, $inIsActive, $inStaffIdNumber )
	{
        $Sql = "UPDATE {$this->Prefix}staff_member
                SET is_active = '{$inIsActive}'
                WHERE staff_id_number = {$inStaffIdNumber}";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "ii", $IsActive, $StaffIdNumber );
        $IsActive = $inIsActive;
        $StaffIdNumber = $inStaffIdNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_close( $Stmt );
	}

//####################################################################
    // GetStaffMembers. Returns the details of each staff member of the company with the given company id.

    public function GetStaffMembers( $inConnection, $inCompanyId )
    {
        $Sql = "SELECT sm.staff_id_number, sm.username, sm.password, sm.email_address, sm.staff_type, sm.is_active, sm.member_type_binary_code, sm.status
                FROM {$this->Prefix}staff_member sm, {$this->Prefix}company_staff_member csm
                WHERE sm.staff_id_number = csm.staff_id_number AND
                      csm.company_id = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $CompanyId );
        $CompanyId = $inCompanyId;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStaffIdNumber, $rUsername, $rPassword, $rEmailAddress, $rStaffType, $rIsActive, $rMemberTypeBinaryCode, $rStatus );
        $StaffMembers = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $StaffMember = array();
            $StaffMember['staff_id_number'] = $rStaffIdNumber;
            $StaffMember['username'] = $rUsername;
            $StaffMember['password'] = $rPassword;
            $StaffMember['email_address'] = $rEmailAddress;
            $StaffMember['staff_type'] = $rStaffType;
            $StaffMember['is_active'] = $rIsActive;
            $StaffMember['member_type_binary_code'] = $rMemberTypeBinaryCode;
            $StaffMember['status'] = $rStatus;
            array_push( $StaffMembers, $StaffMember );
        }

        mysqli_stmt_close( $Stmt );
/********************************************************************

        $StaffMembersTable = mysqli_query( $inConnection,
                                         "SELECT sm.staff_id_number, sm.username, sm.password, sm.email_address, sm.staff_type, sm.is_active, sm.member_type_binary_code, sm.status
                                          FROM {$this->Prefix}staff_member sm, {$this->Prefix}company_staff_member csm
                                          WHERE sm.staff_id_number = csm.staff_id_number AND
                                                csm.company_id = '{$inCompanyId}'" );
        $StaffMembers = array();
        while( $Row = mysqli_fetch_assoc( $StaffMembersTable ) )
        {
            $StaffMember = array();
            $StaffMember['staff_id_number'] = $Row['staff_id_number'];
            $StaffMember['username'] = $Row['username'];
            $StaffMember['password'] = $Row['password'];
            $StaffMember['email_address'] = $Row['email_address'];
            $StaffMember['staff_type'] = $Row['staff_type'];
            $StaffMember['is_active'] = $Row['is_active'];
            $StaffMember['member_type_binary_code'] = $Row['member_type_binary_code'];
            $StaffMember['status'] = $Row['status'];
            array_push( $StaffMembers, $StaffMember );
        }
        mysqli_data_seek( $StaffMembersTable, 0 );
********************************************************************/

        return $StaffMembers;
    }

//--------------------------------------------------------------------
//public function GetStaffMembers( $inConnection )

//        $StaffMembersTable = mysqli_query( $inConnection,
//                                         "SELECT staff_id_number, username, password, email_address, staff_type, is_active, member_type_binary_code, status
//                                          FROM {$this->Prefix}staff_member" );

//####################################################################
    // GetMemberDetails. Returns an array of member details corresponding to the given staff member password.

    public function GetMemberDetails( $inConnection, $inPassword )
    {
		$EncryptedPassword = '';
		$AllMembersTable = $this->GetAllMembers( $inConnection );
        while( $row = mysqli_fetch_array( $AllMembersTable ) )
        {
            if( crypt( $inPassword, $row['password'] ) == $row['password'] )
            {
                $EncryptedPassword = $row['password'];
                break;
            }
        }
        mysqli_data_seek( $AllMembersTable, 0 );

        $Sql = "SELECT sm.staff_id_number, sm.username, sm.password, sm.email_address, sm.staff_type, sm.is_active, sm.member_type_binary_code, sm.status, c.company_id, c.company_name
                FROM {$this->Prefix}staff_member sm, {$this->Prefix}company_staff_member csm, {$this->Prefix}company c
                WHERE sm.staff_id_number = csm.staff_id_number AND
                      csm.company_id = c.company_id AND
                      sm.password = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "s", $pEncryptedPassword );
        $pEncryptedPassword = $EncryptedPassword;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStaffIdNumber, $rUsername, $rPassword, $rEmailAddress, $rStaffType, $rIsActive, $rMemberTypeBinaryCode, $rStatus, $rCompanyId, $rCompanyName );
        $StaffMemberDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $StaffMemberDetails['staff_id_number'] = $rStaffIdNumber;
            $StaffMemberDetails['username'] = $rUsername;
            $StaffMemberDetails['password'] = $rPassword;
            $StaffMemberDetails['email_address'] = $rEmailAddress;
            $StaffMemberDetails['staff_type'] = $rStaffType;
            $StaffMemberDetails['is_active'] = $rIsActive;
            $StaffMemberDetails['member_type_binary_code'] = $rMemberTypeBinaryCode;
            $StaffMemberDetails['status'] = $rStatus;
            $StaffMemberDetails['company_id'] = $rCompanyId;
            $StaffMemberDetails['company_name'] = $rCompanyName;
        }

        return $StaffMemberDetails;
    }

/********************************************************************
        $MemberDetailsTable = mysqli_query( $inConnection,
                                            "SELECT sm.staff_id_number, sm.username, sm.password, sm.email_address, sm.staff_type, sm.is_active, sm.member_type_binary_code, sm.status, c.company_id, c.company_name
                                             FROM {$this->Prefix}staff_member sm, {$this->Prefix}company_staff_member csm, {$this->Prefix}company c
                                             WHERE sm.staff_id_number = csm.staff_id_number AND
                                                   csm.company_id = c.company_id AND
                                                   sm.password = '{$EncryptedPassword}'" );
		$MemberDetails = array();
		while( $Row = mysqli_fetch_assoc( $MemberDetailsTable ) )
		{
			$MemberDetails['staff_id_number'] = $Row['staff_id_number'];
			$MemberDetails['username'] = $Row['username'];
			$MemberDetails['password'] = $Row['password'];
			$MemberDetails['email_address'] = $Row['email_address'];
			$MemberDetails['staff_type'] = $Row['staff_type'];
            $MemberDetails['is_active'] = $Row['is_active'];
            $MemberDetails['member_type_binary_code'] = $Row['member_type_binary_code'];
            $MemberDetails['company_id'] = $Row['company_id'];
            $MemberDetails['company_name'] = $Row['company_name'];
		}

        return $MemberDetails;
********************************************************************/

//--------------------------------------------------------------------
//        $MemberDetailsTable = mysqli_query( $inConnection,
//                                            "SELECT staff_id_number, username, password, email_address, staff_type, is_active, member_type_binary_code, status
//                                             FROM {$this->Prefix}staff_member
//                                             WHERE password = '{$EncryptedPassword}'" );

//####################################################################
    // GetAllMembers. Returns a table of all members.

    public function GetAllMembers( $inConnection )
    {
        $AllMembersTable = mysqli_query( $inConnection,
                                         "SELECT staff_id_number, username, password, email_address, staff_type, is_active
                                          FROM {$this->Prefix}staff_member" );
        mysqli_data_seek( $inAllMembersTable, 0 );

        return $AllMembersTable;
    }

//####################################################################
    // VerifyUser. Verifies that the user with the given password is an active member.

    public function VerifyUser( $inConnection, $inAllMembersTable, $inPassword  )
    {
        $Result = 0;
        while( $row = mysqli_fetch_array( $inAllMembersTable ) )
        {
            if( crypt( $inPassword, $row['password'] ) == $row['password'] )
            {
                $Result = 1;
                break;
            }
        }
        mysqli_data_seek( $inAllMembersTable, 0 );

        return $Result;
    }

//####################################################################
    // GetMember. Returns an SQL table holding the member with the given member id.

    public function GetMember( $inConnection, $inStaffIdNumber  )
    {
/*********************************************************************
        $Sql = "SELECT staff_id_number, username, password, email_address, staff_type, is_active
                FROM {$this->Prefix}staff_member
                WHERE staff_id_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $StaffIdNumber );
        $StaffIdNumber = $inStaffIdNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStaffIdNumber, $rUsername, $rPassword, $rEmailAddress, $rStaffType, $rIsActive );
        mysqli_stmt_close( $Stmt );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $CreditOrderTable below.

*********************************************************************/
        $MemberTable = mysqli_query( $inConnection,
                                     "SELECT staff_id_number, username, password, email_address, staff_type, is_active
                                      FROM {$this->Prefix}staff_member
                                      WHERE staff_id_number = {$inStaffIdNumber}" );
        mysqli_data_seek( $MemberTable, 0 );

        return $MemberTable;
    }

//####################################################################
    // GetMemberDetailsByStaffIdNumber. Returns an SQL table holding the member with the given member id.

    public function GetMemberDetailsByStaffIdNumber( $inConnection, $inStaffIdNumber  )
    {
        $Sql = "SELECT staff_id_number, username, password, email_address, staff_type, is_active, member_type_binary_code, status
                FROM {$this->Prefix}staff_member
                WHERE staff_id_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $StaffIdNumber );
        $StaffIdNumber = $inStaffIdNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStaffIdNumber, $rUsername, $rPassword, $rEmailAddress, $rStaffType, $rIsActive, $rMemberTypeBinaryCode, $rStatus );
        $MemberDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $MemberDetails['staff_id_number'] = $rStaffIdNumber;
            $MemberDetails['username'] = $rUsername;
            $MemberDetails['password'] = $rPassword;
            $MemberDetails['email_address'] = $rEmailAddress;
            $MemberDetails['staff_type'] = $rStaffType;
            $MemberDetails['is_active'] = $rIsActive;
            $MemberDetails['member_type_binary_code'] = $rMemberTypeBinaryCode;
            $MemberDetails['status'] = $rStatus;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $MemberDetailsTable = mysqli_query( $inConnection,
                                           "SELECT staff_id_number, username, password, email_address, staff_type, is_active, member_type_binary_code, status
                                            FROM {$this->Prefix}staff_member
                                            WHERE staff_id_number = {$inStaffIdNumber}" );
        $MemberDetails = array();
        while( $Row = mysqli_fetch_assoc( $MemberDetailsTable ) )
        {
            $MemberDetails['staff_id_number'] = $Row['staff_id_number'];
            $MemberDetails['username'] = $Row['username'];
            $MemberDetails['password'] = $Row['password'];
            $MemberDetails['email_address'] = $Row['email_address'];
            $MemberDetails['staff_type'] = $Row['staff_type'];
            $MemberDetails['is_active'] = $Row['is_active'];
            $MemberDetails['member_type_binary_code'] = $Row['member_type_binary_code'];
            $MemberDetails['status'] = $Row['status'];
        }
        mysqli_data_seek( $MemberDetailsTable, 0 );
*********************************************************************/

        return $MemberDetails;
    }

//####################################################################
    // GetStaffIdNumbers.

    public function GetStaffIdNumbers( $inConnection )
    {
        $StaffIdNumbersTable = mysqli_query( $inConnection,
                                             "SELECT staff_id_number
                                              FROM {$this->Prefix}staff_member" );
        $StaffIdNumbers = array();
        while( $Row = mysqli_fetch_assoc( $StaffIdNumbersTable ) )
        {
            array_push( $StaffIdNumbers, intval( $Row['staff_id_number'] ) );
        }
        mysqli_data_seek( $StaffIdNumbersTable, 0 );

        return $StaffIdNumbers;
    }

//####################################################################
    // GetTaByCompanyName. Returns the TA of the company with the given company name. All TAs have member type binary code 0011, and each company has only one TA. Therefore we can use the given company name and member type binary code 0011 to pick out the TA we want.

    public function GetTaByCompanyName( $inConnection, $inCompanyName )
    {
        $Sql = "SELECT sm.staff_id_number, sm.username, sm.email_address, sm.member_type_binary_code, sm.status, c.company_name
                FROM {$this->Prefix}company c, {$this->Prefix}company_staff_member csm, {$this->Prefix}staff_member sm
                WHERE c.company_id = csm.company_id AND
                      csm.staff_id_number = sm.staff_id_number AND
                      c.company_name = '{$inCompanyName}' AND
                      sm.member_type_binary_code = '0011'";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "s", $CompanyName );
        $CompanyName = $inCompanyName;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStaffIdNumber, $rUsername, $rEmailAddress, $rMemberTypeBinaryCode, $rStatus, $rCompanyName );
        $TaDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $TaDetails['staff_id_number'] = $rStaffIdNumber;
            $TaDetails['username'] = $rUsername;
            $TaDetails['email_address'] = $rEmailAddress;
            $TaDetails['member_type_binary_code'] = $rMemberTypeBinaryCode;
            $TaDetails['status'] = $rStatus;
            $TaDetails['company_name'] = $rCompanyName;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $TaDetailsTable = mysqli_query( $inConnection,
                                        "SELECT sm.staff_id_number, sm.username, sm.email_address, sm.member_type_binary_code, sm.status, c.company_name
                                         FROM {$this->Prefix}company c, {$this->Prefix}company_staff_member csm, {$this->Prefix}staff_member sm
                                         WHERE c.company_id = csm.company_id AND
                                               csm.staff_id_number = sm.staff_id_number AND
                                               c.company_name = '{$inCompanyName}' AND
                                               sm.member_type_binary_code = '0011'" );
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
*********************************************************************/

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

//####################################################################
    // EmailIsUniqueInTeam. Returns true if the given email address does not exist within the given team (company id).

    public function EmailIsUniqueInTeam( $inConnection, $inCompanyId, $inEmailAddress )
    {
        $Sql = "SELECT c.company_id AS company_id
                FROM {$this->Prefix}company c, {$this->Prefix}company_staff_member csm, {$this->Prefix}staff_member sm
                WHERE c.company_id = csm.company_id AND
                      csm.staff_id_number = sm.member_id AND
                      c.company_id = ? AND
                      sm.email_address = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "is", $CompanyId, $EmailAddress );
        $CompanyId = $inCompanyId;
        $EmailAddress = $inEmailAddress;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rCompanyId );
        $MembersDetails = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $MembersDetails['company_id'] = $rCompanyId;
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $MembersDetailsTable = mysqli_query( $inConnection,
                                             "SELECT c.company_id AS company_id
                                              FROM {$this->Prefix}company c, {$this->Prefix}company_staff_member csm, {$this->Prefix}staff_member sm
                                              WHERE c.company_id = csm.company_id AND
                                                    csm.staff_id_number = sm.member_id AND
                                                    c.company_id = {$inCompanyId} AND
                                                    sm.email_address = '{$inEmailAddress}'" );
        $MembersDetails = array();
        while( $Row = mysqli_fetch_assoc( $MembersDetailsTable ) )
        {
            $MembersDetails['company_id'] = $Row['company_id'];
        }
        mysqli_data_seek( $MembersDetailsTable, 0 );
*********************************************************************/

        //return ( mysqli_num_rows( $MembersDetailsTable ) > 0 );
        return ( count( $MembersDetails ) > 0 );
    }

/*
SELECT *
FROM company c, company_member cm, member m
WHERE c.company_id = cm.company_id AND
      cm.member_id = m.member_id AND
      c.company_id = 000001 AND
      m.email_address = 'a@a.com';

*/

//####################################################################
}
//####################################################################
?>
