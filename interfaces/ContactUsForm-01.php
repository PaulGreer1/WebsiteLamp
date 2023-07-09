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
        $html = '';

        $html .= '<div class="copy-heading"><div style="text-align: center;">CONTACT US</div></div>
                  <form method="post" action="' . $this->Registrar->Get('Config')->RootURL . '/crm/contact_us/controller.php">
                  <div class="copy">Fields marked with an asterisk are required</div>

                  <div class="copy-heading" style="padding: 10px; font-size: 18px;">
                  * Email address:<br />
                  <input type="text" name="EmailAddress" maxlength="150" size="30" />
                  </div>

                  <div class="copy-heading" style="padding: 10px; font-size: 18px;">
                  Name:<br />
                  <input type="text" name="Name" maxlength="50" size="30" />
                  </div>

                  <div class="copy-heading" style="padding: 10px; font-size: 18px;">
                  * Message:<br />
                  <!-- <textarea name="Message" maxlength="2000" rows="20" cols="50"></textarea> -->
                  <textarea name="Message" style="width: 100%; height: 150px;" rows="20" cols="50"></textarea>
                  </div>

                  <div class="copy-heading" style="padding: 10px; font-size: 18px;">
                  <input type="submit" name="SendMessage" value="Send message" />
                  </div>

                  </form>';

        return $html;
    }
}

?>
