<?php
//####################################################################
class EditCustomerForm extends View
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

	public function EditCustomerForm()
	{
        $html = '

<div class="container" id="EditCustomer">

    <div class="content-text" style="width: 100%;">

        <b>Edit customer details</b><br />
        Fields marked with an asterisk are required<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/customer_admin/edit_customer/controller.php">

        <div>

            * Contact name<br />
            <input type="text" name="ContactName" value="' . $this->Registrar->Get('ContactName') . '" /><br /><br />

            * Company name<br />
            <input type="text" name="CompanyName" value="' . $this->Registrar->Get('CompanyName') . '" /><br /><br />

            Phone number<br />
            <input type="text" name="PhoneNumber" value="' . $this->Registrar->Get('PhoneNumber') . '" /><br /><br />

            * Email address<br />
            <input type="text" name="EmailAddress" value="' . $this->Registrar->Get('EmailAddress') . '" /><br /><br />

            * Accounts email address<br />
            <input type="text" name="AccountsEmailAddress" value="' . $this->Registrar->Get('AccountsEmailAddress') . '" /><br /><br />

            Add extra internal email addresses for notifications<br />
            <input type="text" name="EmailAddress2" value="' . $this->Registrar->Get('EmailAddress2') . '" /><br />
            <input type="text" name="EmailAddress3" value="' . $this->Registrar->Get('EmailAddress3') . '" /><br />
            <input type="text" name="EmailAddress4" value="' . $this->Registrar->Get('EmailAddress4') . '" /><br /><br />

            Address<br />
            <textarea name="Address" rows="10" cols="30">' . $this->Registrar->Get('Address') . '</textarea><br /><br />

            VAT number<br />
            <input type="text" name="VatNumber" value="' . $this->Registrar->Get('VatNumber') . '" />' .
            $this->Registrar->Get('HiddenFormFieldInputs') .
            '<input type="hidden" name="CustomerId" value="' . $this->Registrar->Get('CustomerId') . '" /><br /><br />

            <input type="submit" name="EditCustomer" value="Save Customer Details" />

        </div>

        </form>

    </div>

</div>';

		return $html;
	}
}
//<select name="CreditLimit" style="width: 300px;">




































//####################################################################
?>
