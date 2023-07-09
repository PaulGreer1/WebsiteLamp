<?php
//####################################################################
class CustomerSearchForm extends View
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

    public function CustomerSearchForm()
    {
        $html = '

<div class="container" id="CustomerSearch">

    <div class="content-text" style="width: 100%; min-height: 1px;">

        <b>Customer search</b><br />
        Enter a value into one or more of the following fields<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/home/controller.php">

        <div>

        Company name:<br />
        <input type="text" name="CompanyName" value="' . $this->Registrar->Get('inCompanyName') . '" /><br /><br />

        Credit account ID:<br />
        <input type="text" name="CreditAccountNumber" value="' . $this->Registrar->Get('inCreditAccountNumber') . '" /><br /><br />

        Email address:<br />
        <input type="text" name="EmailAddress" value="' . $this->Registrar->Get('inEmailAddress') . '" /><br /><br />

        <input type="submit" name="GetStats" value="Search" />' .

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
