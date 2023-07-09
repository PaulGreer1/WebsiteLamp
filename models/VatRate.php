<?php
//####################################################################
// VatRate( VatRateId, Name, Rate )
//####################################################################
class VatRate
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
    // Insert. Inserts a vat rate into the vat_rate table.

    public function Insert( $inConnection, $inVatRateId, $inName, $inRate )
    {
        $Sql = "INSERT INTO {$this->Prefix}vat_rate( vat_rate_id, name, rate )
                VALUES ( ?, ?, ? )";

        $Stmt = mysqli_prepare( $inConnection, $Sql );
        mysqli_stmt_bind_param( $Stmt, "isd", $VatRateId, $Name, $Rate );

        $VatRateId = $inVatRateId;
        $Name = $inName;
        $Rate = $inRate;

        mysqli_stmt_execute( $Stmt );
        mysqli_stmt_close( $Stmt );
    }

//####################################################################
}
//####################################################################
?>
