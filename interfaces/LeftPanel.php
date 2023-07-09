<?php
//####################################################################
class LeftPanel extends View
{
    public $Registrar;

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;
        $Interfaces = array( 'LoginForm.php', 'AppMenu.php' );
        $ExtraInterfaces = array();
        foreach( $ExtraInterfaces as $ExtraInterface )
        {
            array_push( $Interfaces, $ExtraInterface );
        }
        parent::__construct( $inRegistrar, $Interfaces );
    }

    public function LeftPanel()
    {
        $html = '<div class="left-panel">';

        $html .= '<div class="side-panel-box">
                  <p>Left panel, box 1</p>
                  <p>...</p>
                  </div>';

        $html .= '<div class="side-panel-box">
                  <p>Left panel, box 2</p>
                  <p>...</p>
                  </div>';

        $html .= '</div>';

/*
        $html .= '<div style="padding: 0px;">';

        if( $this->Registrar->Get('LoggedIn') )            // If the user is logged in, then display some of the user's details
        {                                                  // along with an app menu.
            $html .= '<div style="padding: 10px;">';
            $html .= '<b>Your login details</b><br /><br />';
            $html .= 'Username: ' . $this->Registrar->Get('GlobalStaffMemberDetails')['username'] . '<br />';
            $html .= 'Company name: ' . $this->Registrar->Get('GlobalStaffMemberDetails')['company_name'] . '<br />';
            $html .= 'Company ID: ' . $this->Registrar->Get('GlobalStaffMemberDetails')['company_id'] . '<br /><br />';
            $html .= '</div>';

            $html .= '<div style="padding: 5px; background-color: #ffffff;">
                      </div>';

            $AppMenu = new AppMenu( $this->Registrar );
            $html .= $AppMenu->AppMenu();
        }
        else // The user is not logged in, so display the login form.
        {
            $LoginForm = new LoginForm( $this->Registrar );

            $html .= '<div style="padding: 10px;">';
            $html .= $LoginForm->LoginForm();
            $html .= '</div>';
        }

        $html .= '</div>';
*/

        return $html;
    }
}
































//####################################################################
?>
