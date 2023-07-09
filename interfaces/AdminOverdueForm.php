<?php
//####################################################################
class AdminOverdueForm extends View
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

	public function AdminOverdueForm()
	{
		$html = '<form method="post" action="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/customer_admin/add_credit_order/controller.php">

                <h4>Are you sure?</h4>

				<p>This customer has orders overdue. All overdue orders should be settled first. Would you like to override this?</p>

				<input type="hidden" name="ContactName" value="' . $this->Registrar->Get('ContactName') . '" />
				<input type="hidden" name="CompanyName" value="' . $this->Registrar->Get('CompanyName') . '" />
				<input type="hidden" name="PhoneNumber" value="' . $this->Registrar->Get('PhoneNumber') . '" />
				<input type="hidden" name="EmailAddress" value="' . $this->Registrar->Get('EmailAddress') . '" />
				<input type="hidden" name="AccountsEmailAddress" value="' . $this->Registrar->Get('AccountsEmailAddress') . '" />
				<input type="hidden" name="Address" value="' . $this->Registrar->Get('Address') . '" />
				<input type="hidden" name="VatNumber" value="' . $this->Registrar->Get('VatNumber') . '" />

				<!--<input type="hidden" name="key" value="' . $this->Registrar->Get('Key') . '" />-->'

                . $html .= $this->Registrar->Get('HiddenFormFieldInputs') .

				'<input type="hidden" name="CustomerId" value="' . $this->Registrar->Get('CustomerId') . '" />

                <input type="submit" name="Cancel" value="Cancel" />
                <input type="submit" name="PlaceOrder" value="Place order" />
                </form>';

		return $html;
	}
}
//####################################################################
?>
