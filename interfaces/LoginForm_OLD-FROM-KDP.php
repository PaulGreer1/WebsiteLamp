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
        return '<h1>Credit control login</h1>
                <form action="' . $this->Registrar->Get('Config')->RootURL . '/index.php">

                Email address<br />
                <input  type="text" name="EmailAddress" maxlength="50" size="30" /><br /><br />

                Password:<br />
                <input type="password" name="Password" maxlength="20" size="30" /><br /><br />

                <input type="hidden" name="key" value="' . $this->Registrar->Get('Key') . '" />

                <input type="submit" name="Login" value="Log in" /> <input type="submit" name="ResetPassword" value="Reset password" /><br /><br />

                </form>';
    }
}

?>
