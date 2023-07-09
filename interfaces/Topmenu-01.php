<?php
//####################################################################
class Topmenu extends View
{
    public $Registrar;
    //################################################################
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
    //################################################################
    public function Topmenu()
    {
        $KeyArg = '?' . $this->Registrar->Get('QueryStringInputs');
        //$html=     '<div class="topmenubar">';
        //========================================================================================================
        $HomeMenu= '<input id="r1" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r1"><a href="' . $this->Registrar->Get('Config')->RootURL . '/index.php' . $KeyArg . '" id="TML1">Home</a></label></div>
                    </div>';

        $html.= $HomeMenu;
        //========================================================================================================
        $PortfolioMenu='<input id="r2" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r2"><a href="' . $this->Registrar->Get('Config')->RootURL . '/brochure/portfolio/controller.php' . $KeyArg . '" id="TML2">Portfolio</a></label></div>
                    </div>';

        $html.= $PortfolioMenu;
        //========================================================================================================
        $ContactMenu='<input id="r3" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r3"><a href="' . $this->Registrar->Get('Config')->RootURL . '/crm/contact_us/controller.php' . $KeyArg . '" id="TML3">Contact</a></label></div>
                    </div>';

        $html.= $ContactMenu;
        //========================================================================================================
        $Link = '';
        if( strlen( $this->Registrar->Get('Key') ) == 0 )
        {
            $Link = '<a href="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php' . $KeyArg . '" id="TML4">Log in or Register</a>';
        }
        else
        {
            $Link = '<a href="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php?LogOut=1" id="TML11">Log out</a>';
        }

        $MembersMenu = '<input id="r4" name="topmenu" type="checkbox" />
                        <div class="node1">
                            <div class="nodelabel"><label for="r4">Members +</label></div>
                            <div class="container1">
                                <div class="node2">
                                    <div class="nodelabel">'
                                    . $Link .
                                    '</div>
                                </div>
                                <div class="node2">
                                    <div class="nodelabel">
                                    <a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/company_directory/list_companies/controller.php' . $KeyArg . '" id="TML5">Directory</a>
                                    </div>
                                </div>
                            </div>
                        </div>';

        $html.= $MembersMenu;
        //========================================================================================================
        $ArticlesMenu = '<input id="r5" name="topmenu" type="checkbox" />
                        <div class="node1">
                            <div class="nodelabel"><label for="r5">Articles +</label></div>
                            <div class="container1">
                                <div class="node2">
                                    <div class="nodelabel">
                                    <a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/you_are_in_good_hands/controller.php' . $KeyArg . '" id="TML6">You\'re in<br />good hands</a>
                                    </div>
                                </div>
                            </div>
                        </div>';

        $html.= $ArticlesMenu;
        //========================================================================================================
        $TeamMenu='<input id="r6" name="topmenu" type="checkbox" />
                        <div class="node1">
                            <div class="nodelabel"><label for="r6">Team +</label></div>
                            <div class="container1">
                                <div class="node2">
                                    <div class="nodelabel">
                                    <a href="' . $this->Registrar->Get('Config')->RootURL . '/brochure/cv/controller.php' . $KeyArg . '" id="TML7">David</a>
                                    </div>
                                </div>
                            </div>
                        </div>';

        $html.= $TeamMenu;
        //========================================================================================================
        $AboutMenu='<input id="r7" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r7"><a href="' . $this->Registrar->Get('Config')->RootURL . '/brochure/portfolio/controller.php' . $KeyArg . '" id="TML8">About</a></label></div>
                    </div>';

//        $html.= $AboutMenu;
        //========================================================================================================
        //$html.='</div>';

        return $html;
    }
    //################################################################
}
//####################################################################
?>
