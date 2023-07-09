<?php
//####################################################################
class Topmenu extends View
{
    public $Registrar;
    public $html = '';
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
        //$this->html =     '<div class="topmenubar">';
        //========================================================================================================
        $HomeMenu= '<input id="r1" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r1"><a href="' . $this->Registrar->Get('Config')->RootURL . '/index.php' . $KeyArg . '" id="TML1">Home</a></label></div>
                    </div>';

        $this->html .= $HomeMenu;
        //========================================================================================================
        $PricingMenu= '<input id="r8" name="topmenu" type="checkbox" />
                       <div class="node1">
                           <div class="nodelabel"><label for="r8"><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/pricing/controller.php' . $KeyArg . '&amp;CategoryId=1" id="TML2">Pricing</a></label></div>
                       </div>';

        $this->html .= $PricingMenu;
        //========================================================================================================
        $ShopMenu= '<input id="r9" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r9"><a href="' . $this->Registrar->Get('Config')->RootURL . '/app_shop/display_items/controller.php' . $KeyArg . '&amp;CategoryId=1" id="TML3">Shop</a></label></div>
                    </div>';

        //$this->html .= $ShopMenu;
        //========================================================================================================
        $PortfolioMenu='<input id="r2" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r2"><a href="' . $this->Registrar->Get('Config')->RootURL . '/brochure/portfolio/controller.php' . $KeyArg . '" id="TML4">Portfolio</a></label></div>
                    </div>';

        //$this->html .= $PortfolioMenu;
        //========================================================================================================
        $ContactMenu='<input id="r3" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r3"><a href="' . $this->Registrar->Get('Config')->RootURL . '/crm/contact_us/controller.php' . $KeyArg . '" id="TML5">Contact</a></label></div>
                    </div>';

        $this->html .= $ContactMenu;
        //========================================================================================================
        $Link = '';
        if( strlen( $this->Registrar->Get('Key') ) == 0 )
        {
            $Link = '<a href="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php' . $KeyArg . '" id="TML6">Log in or Register</a>';
        }
        else
        {
            $Link = '<a href="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php?LogOut=1" id="TML7">Log out</a>';
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
                                    <a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/company_directory/list_companies/controller.php' . $KeyArg . '" id="TML8">Directory</a>
                                    </div>
                                </div>
                            </div>
                        </div>';

        //$this->html .= $MembersMenu;
        //========================================================================================================
        $ArticlesMenu = '<input id="r5" name="topmenu" type="checkbox" />
                         <div class="node1">
                             <div class="nodelabel"><label for="r5">Articles +</label></div>
                             <div class="container1">
<!--
                                 <div class="node2">
                                     <div class="nodelabel">
                                     <a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/you_are_in_good_hands/controller.php' . $KeyArg . '" id="TML9">You\'re in<br />good hands</a>
                                     </div>
                                 </div>
-->
<!--
                                 <div class="node2">
                                     <div class="nodelabel">
                                     <a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/software_industry_standards/controller.php' . $KeyArg . '&amp;Mode=ConstructionEngineer" id="TML10">Software industry standards</a>
                                     </div>
                                 </div>
-->

                                 <div class="node2">
                                     <div class="nodelabel">
                                     <a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/art/quickstart_art/controller.php' . $KeyArg . '" id="TML11">Quickstart art</a>
                                     </div>
                                 </div>

                                 <div class="node2">
                                     <div class="nodelabel">
                                     <a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/art/production_line_art/controller.php' . $KeyArg . '" id="TML12">Production line art</a>
                                     </div>
                                 </div>

                             </div>
                         </div>';

//        $this->html .= $ArticlesMenu;
        //========================================================================================================
        $TeamMenu='<input id="r6" name="topmenu" type="checkbox" />
                        <div class="node1">
                            <div class="nodelabel"><label for="r6">Staff +</label></div>
                            <div class="container1">
                                <div class="node2">
                                    <div class="nodelabel">
                                    <a href="' . $this->Registrar->Get('Config')->RootURL . '/brochure/cv/controller.php' . $KeyArg . '" id="TML13">David</a>
                                    </div>
                                </div>
                            </div>
                        </div>';

        $this->html .= $TeamMenu;
        //========================================================================================================
        $AboutMenu='<input id="r7" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r7"><a href="' . $this->Registrar->Get('Config')->RootURL . '/brochure/portfolio/controller.php' . $KeyArg . '" id="TML14">About</a></label></div>
                    </div>';

//        $html .= $AboutMenu;
        //========================================================================================================
        $ForumsMenu= '<input id="r10" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r10"><a href="' . $this->Registrar->Get('Config')->RootURL . '/forums' . $KeyArg . '" id="TML15">Forums</a></label></div>
                    </div>';

//        $this->html .= $ForumsMenu;
        //========================================================================================================
        $AboutMenu= '<input id="r11" name="topmenu" type="checkbox" />
                    <div class="node1">
                        <div class="nodelabel"><label for="r11"><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/about/controller.php' . $KeyArg . '" id="TML16">About</a></label></div>
                    </div>';

        $this->html .= $AboutMenu;
        //========================================================================================================
        //$this->html .= '</div>';

        return $this->html;
    }
    //################################################################
}
//####################################################################
?>
