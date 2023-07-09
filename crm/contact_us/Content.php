<?php
//####################################################################
class Content extends View
{
    public $Registrar;

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;
        $Interfaces = array();
        $ExtraInterfaces = array( 'ContactUsForm.php' );
        foreach( $ExtraInterfaces as $ExtraInterface )
        {
            array_push( $Interfaces, $ExtraInterface );
        }
        parent::__construct( $inRegistrar, $Interfaces );
    }

    public function Content()
    {
        $ContactUsForm = new ContactUsForm( $this->Registrar );
        $html = '';
        //===================================================================
        if( strlen( $this->Registrar->Get( 'ErrorMessage' ) ) == 0 && ! $this->Registrar->Get( 'MessageSend' ) )  // ErrorMessage string is empty AND NOT MessageSend.
        {
            $html .= $ContactUsForm->ContactUsForm();
        }
        else
        {
            if( $this->Registrar->Get( 'MessageSend' ) )
            {
                $html .= '
                <!-- ############################################################################ -->
                <div class="content-panel">
                <!-- ############################################################################ -->
                <div class="container">
                <!-- ============================================================================ -->
                    <div class="content-article">

                        <h2>Message Sent</h2>

                        <p><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/THANK_YOU_001.png" alt="" /></p>

                        <p>Thank you for your enquiry. We\'ll get back to you shortly.</p>

                    </div>
                <!-- ============================================================================ -->
                </div>
                <!-- ############################################################################ -->
                </div>
                <!-- ############################################################################ -->
                ';
            }
            else // ErrorMessage string is not empty AND NOT MessageSend.
            {
                $html .= $ContactUsForm->ContactUsForm();               // display the form - any error messages will be displayed - see ContactUsForm.php.
            }
        }
        //===================================================================
        return $html;
    }
}
//####################################################################
























?>
