<?php
//####################################################################
class EditQuoteForm extends View
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

	public function EditQuoteForm()
	{
        $html = '

<div class="container" id="CreateNewQuote">

    <div class="content-text" style="width: 100%; min-height: 1px;">

        <b>Editing quote ' . $this->Registrar->Get('QuoteId') . '</b><br />
        Fields marked with an asterisk are required<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->RootURL . '/financial_tools/accounting/quoting/edit_quote/controller.php">

        <div>

        * Customer ID:<br />
        <input type="text" name="CustomerId" value="' . $this->Registrar->Get('CustomerId') . '" /><br /><br />

        * Items:<br />
        <textarea name="InvoiceItems" rows="20" cols="30">' . $this->Registrar->Get('InvoiceItems') . '</textarea><br /><br />

        * Total:<br />
        <input type="text" name="QuoteTotal" value="' . $this->Registrar->Get('QuoteTotal') . '" /><input type="submit" name="CalculateQuoteTotal" value="Calculate" /><br /><br />

        <input type="submit" name="EditQuote" value="Save Quote" />' .

        $this->Registrar->Get('HiddenFormFieldInputs') .

        '<input type="hidden" name="CompanyId" value="' . $this->Registrar->Get('CompanyId') . '" />
        <input type="hidden" name="CustomerId" value="' . $this->Registrar->Get('CustomerId') . '" />
        <input type="hidden" name="QuoteId" value="' . $this->Registrar->Get('QuoteId') . '" />

        </div>

        </form>

    </div>

</div>';

		return $html;
	}
}









































//####################################################################
?>
