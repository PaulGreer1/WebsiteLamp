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
        //$html = '<form method="post" action="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/home/controller.php">';

        $html .=  '<div>

                  Company name:<br />
                  <input type="text" name="CompanyName" value="' . $this->Registrar->Get('inCompanyName') . '" /><br /><br />

                  Credit account ID:<br />
                  <input type="text" name="CreditAccountNumber" value="' . $this->Registrar->Get('inCreditAccountNumber') . '" /><br /><br />

                  Email address:<br />
                  <input type="text" name="EmailAddress" value="' . $this->Registrar->Get('inEmailAddress') . '" /><br /><br />' .

                  $this->Registrar->Get('HiddenFormFieldInputs') .

                  '</div>';

        //$html .= '</form>';

        return $html;
    }
}



















































//####################################################################
?>
