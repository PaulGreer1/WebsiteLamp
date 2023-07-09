<?php
//####################################################################
class Content extends View
{
    public $Registrar;

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;
        $Interfaces = array();
        $ExtraInterfaces = array( 'LoginOrRegisterForm.php' );
        foreach( $ExtraInterfaces as $ExtraInterface )
        {
            array_push( $Interfaces, $ExtraInterface );
        }
        parent::__construct( $inRegistrar, $Interfaces );
    }

    public function Content()
    {
        $LoginOrRegisterForm = new LoginOrRegisterForm( $this->Registrar );
        $html = '';
        //===================================================================
$html .= $this->Registrar->Get( 'NewPassword' );
        if( strlen( $this->Registrar->Get( 'ErrorMessage' ) ) > 0 )
        {
            //$html .= $this->Registrar->Get('ErrorMessage') . $LoginOrRegisterForm->LoginOrRegisterForm();
            $html .= $LoginOrRegisterForm->LoginOrRegisterForm();
        }
        else
        {
            if( $this->Registrar->Get( 'TaRegistered' ) )
            {
                $html .= '
                <!-- ############################################################################ -->
                <div class="content-panel">
                <!-- ############################################################################ -->
                <div class="container" id="TaContentMessage">
                <!-- ============================================================================ -->
                    <div class="content-image-small">
                        <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/WELCOME_BACK_005.jpg" alt="" />
                    </div>
                <!-- ============================================================================ -->
                    <div class="content-text">
                        <h3>TA Message</h3>' .
                        $this->Registrar->Get( 'TaContentMessage' ) . '<br />
                    </div>
                <!-- ============================================================================ -->
                    <div class="content-image">
                        <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/WELCOME_BACK_005.jpg" alt="" />
                    </div>
                <!-- ============================================================================ -->
                </div>
                <!-- ############################################################################ -->
                </div>
                <!-- ############################################################################ -->
                ';
            }
            else
            {
                if( $this->Registrar->Get( 'TsRegistered' ) )
                {
                    $html .= '
                    <!-- ############################################################################ -->
                    <div class="content-panel">
                    <!-- ############################################################################ -->
                    <div class="container" id="TsContentMessage">
                    <!-- ============================================================================ -->
                        <div class="content-image-small">
                            <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/WELCOME_BACK_005.jpg" alt="" />
                        </div>
                    <!-- ============================================================================ -->
                        <div class="content-text">
                            <h3>TS Message</h3>' .
                            $this->Registrar->Get( 'TsContentMessage' ) . '<br />' . $this->Registrar->Get( 'Password' ) . '<br />
                        </div>
                    <!-- ============================================================================ -->
                        <div class="content-image">
                            <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/WELCOME_BACK_005.jpg" alt="" />
                        </div>
                    <!-- ============================================================================ -->
                    </div>
                    <!-- ############################################################################ -->
                    </div>
                    <!-- ############################################################################ -->
                    ';
                }
                else
                {
                    if( $this->Registrar->Get( 'LoggedIn' ) )
                    {
                        $html .= '
                        <!-- ############################################################################ -->
                        <div class="content-panel">
                        <!-- ############################################################################ -->
                        <div class="container" id="WelcomeBack">
                        <!-- ============================================================================ -->
                            <div class="content-image-small">
                                <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/WELCOME_BACK_004.png" alt="" />
                            </div>
                        <!-- ============================================================================ -->
                            <div class="content-text">
                                <h3>Welcome back</h3>
                                Welcome back ' . $this->Registrar->Get('StaffMemberDetails')['username'] . '<br />
                                You are currently logged in for company: ' . $this->Registrar->Get('StaffMemberDetails')['company_name'] . '<br />
                                Company ID: ' . $this->Registrar->Get('StaffMemberDetails')['company_id'] . '<br />
                            </div>
                        <!-- ============================================================================ -->
                            <div class="content-image">
                                <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/WELCOME_BACK_004.png" alt="" />
                            </div>
                        <!-- ============================================================================ -->
                        </div>
                        <!-- ############################################################################ -->
                        </div>
                        <!-- ############################################################################ -->
                        ';
                    }
                    else
                    {
                        $html .= $LoginOrRegisterForm->LoginOrRegisterForm();
                    }
                }
            }
        }
        //===================================================================
        return $html;
    }
}

//====================================================================
//$html .= '<a href="http://www.localtopspek.com/financial_tools/credit_control/home/controller.php?key=' . urlencode( $this->Registrar->Get('Key') ) . '">Credit Control</a>';
//$html .= '<a href="http://www.localtopspek.com/financial_tools/credit_control/home/controller.php?' . $this->Registrar->Get('QueryStringInputs') . '">Credit Control</a>';

//echo 'HERE1<br />';
//echo "\$this->Registrar->Get( 'Registered') = " . $this->Registrar->Get( 'Registered') . '<br />';
//echo "\$this->Registrar->Get( 'LoggedIn') = " . $this->Registrar->Get( 'LoggedIn') . '<br />';
//echo "\$this->Registrar->Get( 'LogOut') = " . $this->Registrar->Get( 'LogOut') . '<br />';
//####################################################################

































?>
