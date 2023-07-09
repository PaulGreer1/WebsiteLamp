<?php
//####################################################################
class ChangeCreditLimitForm extends View
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

	public function ChangeCreditLimitForm()
	{
        $html = '

<div class="container" id="ChangeCreditLimit">

    <div class="content-text" style="width: 100%; min-height: 1px;">

        <b>Change credit limit</b><br />
        Fields marked with an asterisk are required<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/customer_admin/change_credit_limit/controller.php">

        <div>

            * Select credit limit<br />
            <select name="CreditLimit">
            <option value="1000">£1,000</option>
            <option value="2000">£2,000</option>
            <option value="3000">£3,000</option>
            <option value="0">REVOKE CREDIT</option>
            </select><br />

            <input type="hidden" name="ContactName" value="' . $this->Registrar->Get('ContactName') . '" />
            <input type="hidden" name="CompanyName" value="' . $this->Registrar->Get('CompanyName') . '" />
            <input type="hidden" name="PhoneNumber" value="' . $this->Registrar->Get('PhoneNumber') . '" />
            <input type="hidden" name="EmailAddress" value="' . $this->Registrar->Get('EmailAddress') . '" />
            <input type="hidden" name="AccountsEmailAddress" value="' . $this->Registrar->Get('AccountsEmailAddress') . '" />
            <input type="hidden" name="Address" value="' . $this->Registrar->Get('Address') . '" />
            <input type="hidden" name="VatNumber" value="' . $this->Registrar->Get('VatNumber') . '" />'

            . $this->Registrar->Get('HiddenFormFieldInputs') .

            '<input type="hidden" name="CustomerId" value="' . $this->Registrar->Get('CustomerId') . '" /><br />

            <input type="submit" name="UpdateCreditLimit" value="Save Credit Limit" />

        </div>

        </form>

    </div>

</div>';

		return $html;
	}
}














































//####################################################################
?>
