<?php

class LoginForm extends View
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

    public function LoginForm()
    {
        $html = '

<!-- ############################################################################ -->
<div class="container" id="ContactUs">
<!-- ============================================================================ -->
        <b>Member Login</b><br />
        Fields marked with an asterisk are required<br />' .

        $this->Registrar->Get( 'ErrorMessage' ) .

        '<form method="post" action="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php">

        <div>

        * Email address:<br />
        <input type="text" name="EmailAddress" /><br />
<!--
        Name:<br />
        <input type="text" name="CompanyName" /><br />
-->
        * Password:<br />
        <input type="password" name="Password" /><br />

        <input type="submit" name="Login" value="Log in" />

        </div>

        </form>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
';


/*
        // Display logged in user's details.
        $html = '';
        $html .= '<form method="post" action="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php">';
        $html .= '<table id="topspekcredit">';
        $html .= '<tr><th colspan="2">Log in</th></tr>';
        $html .= '<tr><td>* Email</td><td><input type="text" name="EmailAddress" /></td></tr>';
        $html .= '<tr><td>* Company</td><td><input type="text" name="CompanyName" /></td></tr>';
        $html .= '<tr><td>* Password</td><td><input type="password" name="Password" /></td></tr>';
        $html .= '<tr><td colspan="2"><input type="submit" name="Login" value="Log in" /></td></tr>';
        $html .= '</table>';
        $html .= '</form>';
*/

        return $html;
    }
}

?>
