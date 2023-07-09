<?php
//####################################################################
class AppMenu extends View
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

    public function AppMenu()
    {
        $QueryStringInputs = $this->Registrar->Get('QueryStringInputs') . '&amp;CompanyId=' . $this->Registrar->Get('GlobalStaffMemberDetails')['company_id'];

        $html .= '<div style="padding: 10px;">
                      <b>Your Topspek Apps</b><br /><br />

                      <div class="nav-menu">
                          <a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/home/controller.php?' . $QueryStringInputs . '">Dashboard</a><br />
                          <a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/customer_admin/list_customers/controller.php?' . $QueryStringInputs . '">Your customers</a><br />
                          <a href="' . $this->Registrar->Get('Config')->CreditControlAppURL . '/admin/staff_admin/controller.php?' . $QueryStringInputs . '">Staff management</a><br />
                          <a href="' . $this->Registrar->Get('Config')->RootURL . '/financial_tools/pricing/price_finder/controller.php?' . $QueryStringInputs . '">Pricing calculators</a><br />
                          <a href="' . $this->Registrar->Get('Config')->RootURL . '/financial_tools/accounting/quoting/create_quote/controller.php?' . $QueryStringInputs . '">Quoting</a><br />
                      </div>

                  </div>';

        return $html;
    }
}




















































//####################################################################
?>
