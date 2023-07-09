<?php
//####################################################################
// StatementNote( StaffIdNumber, DateTimeStamp, StatementNumber, NoteText )
//####################################################################
class StatementNote
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
    // Insert. Inserts a statement note into the statement_note table.

    public function Insert( $inConnection, $inStatementNoteNumber, $inStaffIdNumber, $inDateTimeStamp, $inStatementNumber, $inNoteText )
    {
        $Sql = "INSERT INTO {$this->Prefix}statement_note( statement_note_number, staff_id_number, date_time_stamp, statement_number, note_text )
                VALUES ( ?, ?, ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "iisis", $StatementNoteNumber, $StaffIdNumber, $DateTimeStamp, $StatementNumber, $NoteText );

        $StatementNoteNumber = $inStatementNoteNumber;
        $StaffIdNumber = $inStaffIdNumber;
        $DateTimeStamp = $inDateTimeStamp;
        $StatementNumber = $inStatementNumber;
        $NoteText = $inNoteText;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $Query = "INSERT INTO {$this->Prefix}statement_note( staff_id_number, date_time_stamp, statement_number, note_text )
                  VALUES ( '{$inStaffIdNumber}', '{$inDateTimeStamp}', '{$inStatementNumber}', '{$inNoteText}' )";

		mysqli_query( $inConnection, $Query ) or die( mysqli_error( $inConnection ) );

DROP TABLE statement_note;

CREATE TABLE statement_note
(
    statement_note_number INT(10) ZEROFILL NOT NULL,
	staff_id_number INT(10) ZEROFILL NOT NULL,
	date_time_stamp DATETIME NOT NULL,
	statement_number INT(10) ZEROFILL NOT NULL,
	note_text VARCHAR(1000) NOT NULL,
	PRIMARY KEY( statement_note_number ),
	FOREIGN KEY( staff_id_number ) REFERENCES staff_member( staff_id_number ),
	FOREIGN KEY( statement_number ) REFERENCES statement( statement_number )
)Engine=InnoDB;

*********************************************************************/
    }

//#################################################################### ALTER TABLE statement_note ADD COLUMN statement_note_number PRIMARY KEY
    // GetStatementNoteNumbers.

    public function GetStatementNoteNumbers( $inConnection )
    {
        $StatementNoteNumbersTable = mysqli_query( $inConnection,
                                                   "SELECT statement_note_number
                                                    FROM {$this->Prefix}statement_note" );
        $StatementNoteNumbers = array();
        while( $Row = mysqli_fetch_assoc( $StatementNoteNumbersTable ) )
        {
            array_push( $StatementNoteNumbers, intval( $Row['statement_note_number'] ) );
        }
        mysqli_data_seek( $StatementNoteNumbersTable, 0 );

        return $StatementNoteNumbers;
    }

//####################################################################
    // GetStatementNotesByStatementNumber. Returns an array holding the details of all statement notes corresponding to the given statement number.

    public function GetStatementNotesByStatementNumber( $inConnection, $inStatementNumber )
    {
        $Sql = "SELECT sn.staff_id_number, sn.date_time_stamp, sn.statement_number, sn.note_text, sm.username
                FROM {$this->Prefix}statement_note sn, {$this->Prefix}staff_member sm
                WHERE sn.staff_id_number = sm.staff_id_number AND
                      sn.statement_number = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "i", $StatementNumber );
        $StatementNumber = $inStatementNumber;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStaffIdNumber, $rDateTimeStamp, $rStatementNumber, $rNoteText, $rUsername );
        $StatementNotes = array();
        while( mysqli_stmt_fetch( $Stmt ) )
        {
            $StatementNote = array();
			$StatementNote['staff_id_number'] = $rStaffIdNumber;
			$StatementNote['date_time_stamp'] = $rDateTimeStamp;
			$StatementNote['statement_number'] = $rStatementNumber;
			$StatementNote['note_text'] = $rNoteText;
			$StatementNote['username'] = $rUsername;
            array_push( $StatementNotes, $StatementNote );
        }

        mysqli_stmt_close( $Stmt );
/*********************************************************************
        $StatementNotesTable = mysqli_query( $inConnection,
                                             "SELECT sn.staff_id_number, sn.date_time_stamp, sn.statement_number, sn.note_text, sm.username
                                              FROM {$this->Prefix}statement_note sn, {$this->Prefix}staff_member sm
                                              WHERE sn.staff_id_number = sm.staff_id_number AND
                                                    sn.statement_number = {$inStatementNumber}" );
		$StatementNotes = array();
		while( $Row = mysqli_fetch_assoc( $StatementNotesTable ) )
		{
            $StatementNote = array();
			$StatementNote['staff_id_number'] = $Row['staff_id_number'];
			$StatementNote['date_time_stamp'] = $Row['date_time_stamp'];
			$StatementNote['statement_number'] = $Row['statement_number'];
			$StatementNote['note_text'] = $Row['note_text'];
			$StatementNote['username'] = $Row['username'];
            array_push( $StatementNotes, $StatementNote );
		}
        mysqli_data_seek( $StatementNotesTable, 0 );
*********************************************************************/

        return $StatementNotes;
    }

//####################################################################
    // NOT USED ANYWHERE. GetStatementNote. Returns the statement note with the given staff id number and datetimestamp.

    public function GetStatementNote( $inConnection, $inStaffIdNumber, $inDateTimeStamp  )
    {
/*********************************************************************
        $Sql = "SELECT staff_id_number, date_time_stamp, statement_number, note_text
                FROM {$this->Prefix}statement_note
                WHERE staff_id_number = ? AND
                      date_time_stamp = ?";
        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "is", $StaffIdNumber, $DateTimeStamp );
        $StaffIdNumber = $inStaffIdNumber;
        $DateTimeStamp = $inDateTimeStamp;

        mysqli_stmt_execute( $Stmt );

        mysqli_stmt_bind_result( $Stmt, $rStaffIdNumber, $rDateTimeStamp, $rStatementNumber, $rNoteText );
        mysqli_stmt_close( $Stmt );

        return $Stmt;   // Before implementing this code, find out whether $Stmt is equivalent to $CreditOrderTable below.

*********************************************************************/
        $StatementNoteTable = mysqli_query( $inConnection,
                                            "SELECT *
                                             FROM {$this->Prefix}statement_note
                                             WHERE staff_id_number = {$inStaffIdNumber} AND
                                                   date_time_stamp = {$inDateTimeStamp}" );
        return $StatementNoteTable;
    }

//####################################################################
}


















































//####################################################################
?>
