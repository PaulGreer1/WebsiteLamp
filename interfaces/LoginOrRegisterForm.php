<?php

class LoginOrRegisterForm extends View
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

    public function LoginOrRegisterForm()
    {
        $html = '';

        $html .= '

<!-- ############################################################################ -->
<div class="content-panel">
<!-- ############################################################################ -->
<div class="container" id="LoginOrRegister">
<!-- ============================================================================ -->
    <div class="content-image-small">
        <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/LOGIN_003.jpg" alt="" />
    </div>
<!-- ============================================================================ -->
    <div class="content-text">' .

        $this->Registrar->Get( 'ErrorMessage' ) .

        '<h3>Log in or register</h3>
        Fields marked with an asterisk are required<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php">

        <div>

        <h3>Log in</h3>

        * Email address:<br />
        <input type="text" name="EmailAddress" /><br /><br />

        * Company name:<br />
        <input type="text" name="CompanyName" /><br /><br />

        * Password:<br />
        <input type="password" name="Password" /><br /><br />

        <input type="submit" name="Login" value="Log in" /><br /><br />

        <h3>Register</h3>

        What type of membership do you want?<br /><br />
        <input type="radio" name="StaffType" value="TaOfNewCo" /> Team Admin of new company<br /><br />
        <input type="radio" name="StaffType" value="TsOfExistingCo" /> Team Staff of existing company<br /><br />

        * Email address:<br />
        <input type="text" name="EmailAddress" /><br /><br />

        * Name:<br />
        <input type="text" name="MemberName" /><br /><br />

        * Company name:<br />
        <input type="text" name="CompanyName" /><br /><br />

        * Confirm company name:<br />
        <input type="text" name="ConfirmCompanyName" /><br /><br />

        <img style="width: 200px;" src="' . $this->Registrar->Get('Config')->RootURL . '/resources/captcha/' . $this->Registrar->Get('CCPngName') . '.png" alt="" /><br /><br />
        * Image code:<br />
        <input type="text" name="CaptchaCode" /><br /><br />

        <input type="submit" name="Register" value="Register" /><br /><br />

        </div>

        </form>

    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/LOGIN_003.jpg" alt="" />
    </div>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
</div>
<!-- ############################################################################ -->
';
        return $html;
    }
}

?>
