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
        // Display logged in user's details.
        $html = '';
        $html .= '<form method="post" action="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php">';
        $html .= '<table id="topspekcredit">';
        $html .= '<tr><th colspan="2">Log in</th></tr>';
        $html .= '<tr><td>* Email</td><td><input type="text" name="EmailAddress" maxlength="200" size="30" /></td></tr>';
        $html .= '<tr><td>* Company</td><td><input type="text" name="CompanyName" maxlength="200" size="30" /></td></tr>';
        $html .= '<tr><td>* Password</td><td><input type="password" name="Password" maxlength="20" size="30" /></td></tr>';
        $html .= '<tr><td colspan="2"><input type="submit" name="Login" value="Log in" /></td></tr>';
        $html .= '</table>';
        $html .= '</form>';

        return $html;
    }
}

?>
