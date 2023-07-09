<?php
//####################################################################
class CustomerAdminPanelContent extends View
{
	public $Registrar;

	public function __construct( $inRegistrar, $Interfaces = array() )
	{
		$this->Registrar = $inRegistrar;		
		$ExtraInterfaces = array( 'EditCustomerForm.php', 'ChangeCreditLimitForm.php', 'AddCreditOrderForm.php', 'AddCustomerForm.php' );
		foreach( $ExtraInterfaces as $ExtraInterface )
		{
			array_push( $Interfaces, $ExtraInterface );
		}
		parent::__construct( $inRegistrar, $Interfaces );
	}

	public function Content()
	{
        $html = '<div class="content-panel">';

        $html .= '<div class="content-text" style="width: 100%; min-height: 1px;">
                  <h3>Customer Admin</h3>
                  <a href="' . $this->Registrar->Get('Config')->RootURL . '/financial_tools/accounting/quoting/create_quote/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&amp;CompanyId=' . $this->Registrar->Get('company_id') . '">Create a Quote</a>
                  </div>';

		$EditCustomerForm = new EditCustomerForm( $this->Registrar );
		$ChangeCreditLimitForm = new ChangeCreditLimitForm( $this->Registrar );
		$AddCreditOrderForm = new AddCreditOrderForm( $this->Registrar );

		if( $this->Registrar->Get('LoggedIn') )
		{
            //===========================================================
			$html .= $EditCustomerForm->EditCustomerForm();
            //-----------------------------------------------------------
            if( $this->Registrar->Get('StaffType') == 'Admin' )
            {
    			$html .= $ChangeCreditLimitForm->ChangeCreditLimitForm();
            }
            //-----------------------------------------------------------
			$html .= $AddCreditOrderForm->AddCreditOrderForm();
            //===========================================================
            // CREDIT STATUS

            $html .= '<div class="container" id="CreditStatus">
                      <div class="content-text" style="width: 100%; min-height: 1px;">';

            $html .= '<b>Credit status</b><br />';
            $html .= '<table>';
            $html .= '<tr>';
            $html .= '<th>Current credit limit</th>
                      <th>In use</th>
                      <th>Available</th>';
            $html .= '</tr>';
            $html .= '<tr><td style="text-align: center;">£' . $this->Registrar->Get('CurrentCreditLimit') . '</td><td style="text-align: center;">£' . $this->Registrar->Get('CreditInUse') . '</td><td style="text-align: center;">£' . $this->Registrar->Get('CreditAvailable') . '</td></tr>';
            $html .= '</table>';

            $html .= '</div>
                      </div>';
            //===========================================================
            $Now = date( 'Y-m-d' );
            //===========================================================
            // STATEMENTS UNPAID AND OVERDUE

            $html .= '<div class="container" id="StatementsUnpaidAndOverdue">
                      <div class="content-text" style="width: 100%; min-height: 1px;">';

            $html .= '<b>Statements unpaid and overdue</b><br />';
            $html .= '<table>';
            $html .= '<tr>';
            $html .= '<th>Due date</th>';
            $html .= '<th>Total</th>';
            $html .= '<th>Amount outstanding</th>';
            $html .= '<th>Overdue by</th>';
            $html .= '<th>Notes</th>';
            $html .= '<th>&nbsp;</th>';
            $html .= '</tr>';
            foreach( $this->Registrar->Get('StatementsOverdue') as $StatementOverdue )
            {
                $StatementDueDate = date_format( date_create( $StatementOverdue[4] ), 'd-m-Y' );
                $html .= '<tr><td class="tdn">' . $StatementDueDate . '</td><td class="tdn">£' . $StatementOverdue[2] . '</td><td class="tdn">£' . $StatementOverdue[3] . '</td><td class="tdn">' . abs( round( ( strtotime( $Now ) - strtotime( $StatementDueDate ) ) / ( 60 * 60 * 24 ) ) ) . '</td><td class="tdn">' . $StatementOverdue[8] . '</td><td class="tdn"><a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/statement_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&amp;StatementYear=' . date( 'Y', strtotime( $StatementOverdue[1] ) ) . '&amp;StatementMonth=' . date( 'm', strtotime( $StatementOverdue[1] ) ) . '">Details</a></td></tr>';
            }
            $html .= '</table>';

            $html .= '</div>
                      </div>';
            //===========================================================
            // STATEMENTS UNPAID BUT NOT OVERDUE

            $html .= '<div class="container" id="StatementsUnpaidButNotOverdue"><div class="content-text" style="width: 100%; min-height: 1px;">';

            $html .= '<b>Statements unpaid but not overdue</b><br />';
            $html .= '<table>';
            $html .= '<tr>';
            $html .= '<th>Due date</th>';
            $html .= '<th>Total</th>';
            $html .= '<th>Amount outstanding</th>';
            $html .= '<th>Days until due</th>';
            $html .= '<th>Notes</th>';
            $html .= '<th>&nbsp;</th>';
            $html .= '</tr>';
            foreach( $this->Registrar->Get('StatementsOnCredit') as $StatementOnCredit )
            {
                $StatementDueDate = date_format( date_create( $StatementOnCredit[4] ), 'd-m-Y' );
                $html .= '<tr><td class="tdn">' . $StatementDueDate . '</td><td class="tdn">£' . $StatementOnCredit[2] . '</td><td class="tdn">£' . $StatementOnCredit[3] . '</td><td class="tdn">' . abs( round( ( strtotime( $Now ) - strtotime( $StatementDueDate ) ) / ( 60 * 60 * 24 ) ) ) . '</td><td class="tdn">' . $StatementOnCredit[8] . '</td><td class="tdn"><a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/statement_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&amp;StatementYear=' . date( 'Y', strtotime( $StatementOnCredit[1] ) ) . '&amp;StatementMonth=' . date( 'm', strtotime( $StatementOnCredit[1] ) ) . '">Details</a></td></tr>';

            }
            $html .= '</table>';

            $html .= '</div></div>';
            //===========================================================

            $html .= '<div class="container" id="StatementsPaid">
                      <div class="content-text" style="width: 100%; min-height: 1px;">';

            $html .= '<b>Statements paid</b><br />';
            $html .= '<table id="topspekcredit">';
            $html .= '<tr>';
            $html .= '<th>Due date</th>';
            $html .= '<th>Total</th>';
            $html .= '<th>Amount outstanding</th>';
            $html .= '<th>Days past due date</th>';
            $html .= '<th>Notes</th>';
            $html .= '<th>&nbsp;</th>';
            $html .= '</tr>';
            foreach( $this->Registrar->Get('StatementsPaid2') as $StatementPaid )
            {
                $StatementDueDate = date_format( date_create( $StatementPaid[4] ), 'd-m-Y' );
                $html .= '<tr><td class="tdn">' . $StatementDueDate . '</td><td class="tdn">£' . $StatementPaid[2] . '</td><td class="tdn">£' . $StatementPaid[3] . '</td><td class="tdn">' . abs( round( ( strtotime( $Now ) - strtotime( $StatementDueDate ) ) / ( 60 * 60 * 24 ) ) ) . '</td><td class="tdn">' . $StatementPaid[8] . '</td><td class="tdn"><a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/statement_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&amp;StatementYear=' . date( 'Y', strtotime( $StatementPaid[1] ) ) . '&amp;StatementMonth=' . date( 'm', strtotime( $StatementPaid[1] ) ) . '">Details</a></td></tr>';

            }
            $html .= '</table>';

            $html .= '</div>
                      </div>';
            //===========================================================
		}
		else
		{
			$html .= $AddCustomerForm->AddCustomerForm();
		}

        $html .= '</div>';

		return $html;
	}
}







































//####################################################################
?>
