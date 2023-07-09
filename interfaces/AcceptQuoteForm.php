<?php
//####################################################################
class AcceptQuoteForm extends View
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

	public function AcceptQuoteForm()
	{
        $html = '

<div class="container" id="CreateNewQuote">

    <div class="content-text" style="width: 100%; min-height: 1px;">

        <b>Accept quote</b><br />
        Fields marked with an asterisk are required<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->RootURL . '/financial_tools/accounting/quoting/accept_quote/controller.php">

        <div>

        * Date:<br />
        <input type="text" name="CreationDate" id="datepicker7" value="' . date( 'Y-m-d' ) . '" /><br /><br />

        <input type="submit" name="AddCreditOrder" value="Accept Quote" />' .

        $this->Registrar->Get('HiddenFormFieldInputs') .

        '<input type="hidden" name="CompanyId" value="' . $this->Registrar->Get('CompanyId') . '" />
        <input type="hidden" name="CustomerId" value="' . $this->Registrar->Get('CustomerId') . '" />
        <input type="hidden" name="QuoteId" value="' . $this->Registrar->Get('QuoteId') . '" />
        <input type="hidden" name="TotalPrice" value="' . $this->Registrar->Get('QuoteTotal') . '" />

        </div>

        </form>

    </div>

</div>';

		return $html;
	}
}



















































//####################################################################
?>
