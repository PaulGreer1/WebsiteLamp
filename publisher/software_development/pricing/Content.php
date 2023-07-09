<?php
//####################################################################
class Content extends View
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

    public function Content()
    {
        $html = '
<!-- ############################################################################ -->
<div class="content-panel">
<!-- ############################################################################ -->
<div class="container">
<!-- ============================================================================ -->
    <div class="content-article">

        <h2>Pricing</h2>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/mobile_apps/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/PRICING_00002_460x320.png" alt="" /></a></p>

        <h2>For as little as £30, we can create a simple app and deploy it on the Google Play Store ready to be installed by your customers and staff.</h2>

        <p>In order to provide our customers with accurate pricing for their projects, we use a precise \'scope -> deadline -> price\' quoting system. Basically, we start by scoping the project around a precise set of requirements. This gives us an accurate deadline to meet, which enables us to give an accurate price for the project.</p>

        <p>But at the same time, we understand that conditions sometimes change as a project progresses, and that you might need to add or subtract from your requirements at any time during the project. You might even need to pause one set of tasks and start on another set at any time.</p>

        <p>After 21 years in software development, I\'ve learned to work in a highly organised and efficient manner. This enables us to complete projects quickly, and this is another reason why we can offer such highly competitive rates.</p>

        <p>Also, we have accumulated a great deal of tried and tested code which we often incorporate into various projects, and this also helps to keep our overall prices low.</p>

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
//####################################################################




































?>
