<?php
//####################################################################
class Service
{
//==================================================================
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
    // GenerateLowestUniqueIdNumber returns the lowest unique number in a set which is not already in the set, and which is greater than zero. For example, the lowest, new, unique number in {1,2,5,8} is 3. The input set $inSetOfNumbers must be an ordered set. $inSetOfNumbers is often compiled from Service::SQLTableToArray.

    public function GenerateLowestUniqueIdNumber( $inSetOfNumbers )
    {
        sort( $inSetOfNumbers );
        $UniqueNumber = 1;
        $Count = 1;
        foreach( $inSetOfNumbers as $Number )
        {
            if( $Number == $Count )
            {
                $Count = $Count + 1;
                $UniqueNumber = $Count;
            }
            else
            {
                break;
            }
        }
        return $UniqueNumber;
    }

//==================================================================
    // SQLTableToArray turns a table obtained from a 'mysqli_query()' statement into an array...currently accepts only a single-column table and returns a one-dimensional array...

    public function SQLTableToArray( $inConnection, $inTable, $inColumnName )
    {
		$inTable = $this->Prefix . $inTable;
        $Table = mysqli_query( $inConnection,
                              "SELECT {$inColumnName} AS ColumnValue
                               FROM {$inTable}
                               ORDER BY {$inColumnName}" );

        $ArrayToReturn = array();
        $Count = 0;
        while( $row = mysqli_fetch_array( $Table ) )
        {
            $ArrayToReturn[$Count] = $row['ColumnValue'];
            $Count = $Count + 1;
        }

        return $ArrayToReturn;
    }

//==================================================================
    // GenerateRandomString returns a random string of length $inLength characters.

    public function GenerateRandomString( $inLength )
    {
        $CharacterPool = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $RandomString = "";
        for( $i = 0; $i < $inLength; $i++ )
        {
            $RandomString = $RandomString . substr( $CharacterPool, rand( 0, 61 ), 1 );
        }
        return $RandomString;
    }

//==================================================================
    // Exists

    public function Exists( $inConnection, $inTableName, $inColumnName, $inColumnValue )
    {
        $Table = mysqli_query( $inConnection,
                               "SELECT {$inColumnName} AS ColumValue
                                FROM {$this->Prefix}{$inTableName}
                                WHERE {$inColumnName} = '{$inColumnValue}'" );

        return ( mysqli_num_rows( $Table ) > 0 );
    }

//==================================================================
	// GetNowMinusLastDay. Returns the number of days between the current date and the last day of the month in a given date.

	public function GetNowMinusLastDay( $inDate )
	{
		return round( ( strtotime( date( 'Y-m-d' ) ) - strtotime( date( 'Y-m-t', strtotime( $inDate ) ) ) ) / ( 60 * 60 * 24 ) );
	}

//====================================================================
	// GetDateOfLastDayOfMonth. Returns the date of the last day of the month of a given date.

	public function GetDateOfLastDayOfMonth( $inDate )
	{
		return date( 'Y-m-t', strtotime( $inDate ) );
	}

//====================================================================
	// DateDiff. Returns the number of days between two date strings, e.g. '2018-04-13'.

	public function DateDiff( $inDate1, $inDate2 )
	{
		return round( ( strtotime( $inDate1 ) - strtotime( $inDate2 ) ) / ( 60 * 60 * 24 ) );
	}

//====================================================================
}
//####################################################################
?>
