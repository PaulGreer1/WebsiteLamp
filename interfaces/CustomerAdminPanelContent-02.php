<?php
//####################################################################
class CustomerAdminPanelContent extends View
{
	public $Registrar;

	public function __construct( $inRegistrar, $Interfaces = array() )
	{
		$this->Registrar = $inRegistrar;
		//$Interfaces = array();		
		$ExtraInterfaces = array( 'EditCustomerForm.php', 'ChangeCreditLimitForm.php', /*'CreateQuoteForm.php',*/ 'AddCreditOrderForm.php', 'AddCustomerForm.php' /*'LoginForm.php'*/ );     //********************* CREATE QUOTE FORM *************************
		foreach( $ExtraInterfaces as $ExtraInterface )
		{
			array_push( $Interfaces, $ExtraInterface );
		}
		parent::__construct( $inRegistrar, $Interfaces );
	}

	public function Content()
	{
//		$html = '<div><h3>KDPCredit</h3></div>';
//        $html .= '| <a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/home/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '">Main Page' . '</a> | ';
//        $html .= '<a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/staff_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '">Staff Admin</a> |';
        $html .= '<a href="' . $this->Registrar->Get('Config')->RootURL . '/financial_tools/accounting/quoting/create_quote/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&CustomerId=' . $this->Registrar->Get('CustomerId') . '&CompanyId=' . $this->Registrar->Get('company_id') . '">Create a Quote</a> |';
		$EditCustomerForm = new EditCustomerForm( $this->Registrar );
		$ChangeCreditLimitForm = new ChangeCreditLimitForm( $this->Registrar );
//        $CreateQuoteForm = new CreateQuoteForm( $this->Registrar );                                    //********************* CREATE QUOTE FORM *************************
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
            //$html .= $CreateQuoteForm->CreateQuoteForm();                                    //********************* CREATE QUOTE FORM *************************
            //-----------------------------------------------------------
			$html .= $AddCreditOrderForm->AddCreditOrderForm();
            //===========================================================
            $html .= '<h4>Credit status</h4>';
            $html .= '<table id="topspekcredit">';
            $html .= '<tr>';
            $html .= '<th>Current credit limit</th>
                      <th>In use</th>
                      <th>Available</th>';
            $html .= '</tr>';
            $html .= '<tr><td>£' . $this->Registrar->Get('CurrentCreditLimit') . '</td><td>£' . $this->Registrar->Get('CreditInUse') . '</td><td>£' . $this->Registrar->Get('CreditAvailable') . '</td></tr>';
            $html .= '</table>';
            //===========================================================
            $Now = date( 'Y-m-d' );
            //===========================================================
            $html .= '<h4>Statements unpaid and overdue</h4>';
            $html .= '<table id="topspekcredit">';
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
//                $html .= '<tr><td>' . $StatementOverdue[4] . '</td><td>£' . $StatementOverdue[2] . '</td><td>£' . $StatementOverdue[3] . '</td><td>' . abs( round( ( strtotime( $Now ) - strtotime( $StatementOverdue[4] ) ) / ( 60 * 60 * 24 ) ) ) . '</td><td><a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/statement_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&StatementYear=' . date( 'Y', strtotime( $StatementOverdue[1] ) ) . '&StatementMonth=' . date( 'm', strtotime( $StatementOverdue[1] ) ) . '">Details</a></td></tr>';

                $StatementDueDate = date_format( date_create( $StatementOverdue[4] ), 'd-m-Y' );
                $html .= '<tr><td>' . $StatementDueDate . '</td><td>£' . $StatementOverdue[2] . '</td><td>£' . $StatementOverdue[3] . '</td><td>' . abs( round( ( strtotime( $Now ) - strtotime( $StatementDueDate ) ) / ( 60 * 60 * 24 ) ) ) . '</td><td>' . $StatementOverdue[8] . '</td><td><a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/statement_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&StatementYear=' . date( 'Y', strtotime( $StatementOverdue[1] ) ) . '&StatementMonth=' . date( 'm', strtotime( $StatementOverdue[1] ) ) . '">Details</a></td></tr>';
            }
            $html .= '</table>';
            //===========================================================
            $html .= '<h4>Statements unpaid but not overdue</h4>';
            $html .= '<table id="topspekcredit">';
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
                $html .= '<tr><td>' . $StatementDueDate . '</td><td>£' . $StatementOnCredit[2] . '</td><td>£' . $StatementOnCredit[3] . '</td><td>' . abs( round( ( strtotime( $Now ) - strtotime( $StatementDueDate ) ) / ( 60 * 60 * 24 ) ) ) . '</td><td>' . $StatementOnCredit[8] . '</td><td><a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/statement_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&StatementYear=' . date( 'Y', strtotime( $StatementOnCredit[1] ) ) . '&StatementMonth=' . date( 'm', strtotime( $StatementOnCredit[1] ) ) . '">Details</a></td></tr>';

                //$html .= '<tr><td>' . date_format( date_create( $StatementOnCredit[4] ), 'd-m-Y' ) . '</td><td>£' . $StatementOnCredit[2] . '</td><td>£' . $StatementOnCredit[3] . '</td><td>' . abs( round( ( strtotime( $Now ) - strtotime( $StatementOnCredit[4] ) ) / ( 60 * 60 * 24 ) ) ) . '</td><td><a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/statement_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&StatementYear=' . date( 'Y', strtotime( $StatementOnCredit[1] ) ) . '&StatementMonth=' . date( 'm', strtotime( $StatementOnCredit[1] ) ) . '">Details</a></td></tr>';
            }
            $html .= '</table>';
            //===========================================================
            $html .= '<h4>Statements paid</h4>';
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
                $html .= '<tr><td>' . $StatementDueDate . '</td><td>£' . $StatementPaid[2] . '</td><td>£' . $StatementPaid[3] . '</td><td>' . abs( round( ( strtotime( $Now ) - strtotime( $StatementDueDate ) ) / ( 60 * 60 * 24 ) ) ) . '</td><td>' . $StatementPaid[8] . '</td><td><a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/statement_admin/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '&amp;CustomerId=' . $this->Registrar->Get('CustomerId') . '&StatementYear=' . date( 'Y', strtotime( $StatementPaid[1] ) ) . '&StatementMonth=' . date( 'm', strtotime( $StatementPaid[1] ) ) . '">Details</a></td></tr>';

                //$html .= $StatementPaid[0] . ' | ' . $StatementPaid[1] . ' | ' . $StatementPaid[2] . '<br />';
            }
            $html .= '</table>';
            //===========================================================
		}
		else
		{
			$html .= $AddCustomerForm->AddCustomerForm();
		}

		return $html;
	}
}
//####################################################################
?>
