<?php
//####################################################################
class StatsBoxForm extends View
{
    public $Registrar;

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;
        $Interfaces = array();
        $ExtraInterfaces = array();
        foreach( $ExtraInterfaces as $ExtraInterface )
        {
            array_push( $Interfaces, $ExtraInterface );
        }
        parent::__construct( $inRegistrar, $Interfaces );
    }

    public function StatsBoxForm()
    {
        $html = '

<div class="container" id="QuickStats1">

    <div class="content-text" style="width: 100%; min-height: 1px;">

        <b>Quick stats</b><br />
        Fields marked with an asterisk are required<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/home/controller.php">

        <div>

        From date:<br />
        <input type="text" name="StatsBoxFromDate" id="datepicker" value="' . $this->Registrar->Get('inStatsBoxFromDate') . '" /><br /><br />

        To date:<br />
        <input type="text" name="StatsBoxToDate" id="datepicker2" value="' . $this->Registrar->Get('inStatsBoxToDate') . '" /><br /><br />

        <input type="submit" name="GetStats" value="Get stats" />' .

        $this->Registrar->Get('HiddenFormFieldInputs') .

        '</div>

        </form>

    </div>

</div>';

		return $html;
    }
}






















































//####################################################################
?>
