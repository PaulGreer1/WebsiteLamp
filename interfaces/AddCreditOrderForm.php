<?php
//####################################################################
class AddCreditOrderForm extends View
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

	public function AddCreditOrderForm()
	{
		$html = '

<div class="container" id="AddCreditOrder">

    <div class="content-text" style="width: 100%; min-height: 1px;">

        <b>Add new order</b><br />
        Fields marked with an asterisk are required<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/customer_admin/add_credit_order/controller.php">

        <div>

            Custom invoice number:<br />
            <input type="text" name="CustomInvoiceNumber" value="" /><br /><br />

            * Total:<br />
            <input type="text" name="TotalPrice" value="' . $this->Registrar->Get('TotalPrice') . '" /><br /><br />

            * Date:<br />
            <input type="text" name="CreationDate" id="datepicker" value="' . date( 'Y-m-d' ) . '" /><br />

            <!-- Internal email:
            <input type="text" name="InternalEmail" value="' . $this->Registrar->Get('InternalEmail') . '" /><br /><br /> -->

            <input type="hidden" name="ContactName" value="' . $this->Registrar->Get('ContactName') . '" />
            <input type="hidden" name="CompanyName" value="' . $this->Registrar->Get('CompanyName') . '" />
            <input type="hidden" name="PhoneNumber" value="' . $this->Registrar->Get('PhoneNumber') . '" />
            <input type="hidden" name="EmailAddress" value="' . $this->Registrar->Get('EmailAddress') . '" />
            <input type="hidden" name="AccountsEmailAddress" value="' . $this->Registrar->Get('AccountsEmailAddress') . '" />
            <input type="hidden" name="Address" value="' . $this->Registrar->Get('Address') . '" />
            <input type="hidden" name="VatNumber" value="' . $this->Registrar->Get('VatNumber') . '" />
            <!-- <input type="hidden" name="key" value="' . $this->Registrar->Get('Key') . '" /> -->'

            . $html .= $this->Registrar->Get('HiddenFormFieldInputs') .

            '<input type="hidden" name="CustomerId" value="' . $this->Registrar->Get('CustomerId') . '" /><br />

            <input type="submit" name="AddCreditOrder" value="Add Credit Order" />

        </div>

        </form>

    </div>

</div>';

		return $html;
	}
}



















































//####################################################################
?>
