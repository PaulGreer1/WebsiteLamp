<?php

class ContactUsForm extends View
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

    public function ContactUsForm()
    {
        $html = '

<div class="content-panel">

    <div class="container">
        <!-- ===================================================== -->
        <div class="content-article" style="height: 100%;">' .
        $this->Registrar->Get( 'ErrorMessage' ) .

        '<h2>Contact me</h2>
        Fields marked with an asterisk are required<br /><br />

        <form method="post" action="' . $this->Registrar->Get('Config')->RootURL . '/crm/contact_us/controller.php">
            <div>
            * Email address:<br />
            <input type="text" name="EmailAddress" /><br /><br />
            Name:<br />
            <input type="text" name="Name" /><br /><br />
            * Message:<br />
            <textarea name="Message" style="width: 100%; height: 150px;" rows="20" cols="50"></textarea><br /><br />

            <img style="width: 200px;" src="' . $this->Registrar->Get('Config')->RootURL . '/resources/captcha/' . $this->Registrar->Get('CCPngName') . '.png" alt="" /><br /><br />
            * Image code:<br />
            <input type="text" name="CaptchaCode" /><br /><br />

            <input type="submit" name="SendMessage" value="Send message" />
            </div>
        </form>

        </div>
        <!-- ===================================================== -->
    </div>

</div>';

        return $html;
    }
}





























?>
