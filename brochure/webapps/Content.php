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
<div class="container" id="CustomSoftware">

    <div class="content-text" style="width: 100%; min-height: 0px; background-color: #ffffff;">
        <h1><!--WHO. WHERE. WHY. WHAT.-->Fast, secure, responsive websites created with PHP and MySQL</h1>
    </div>

<!-- ============================================================================ -->
    <div class="content-image-small">
        <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/process-automation.jpeg" alt="" />
    </div>
<!-- ============================================================================ -->
    <div class="content-text">
        <h2><!--WHAT, WHY-->Bespoke web applications for large or small businesses</h2>
        <p>We use LAMP (Linux, Apache, MySQL, PHP) for our software creation and development services.</p>
        <p>Whether you\'re an organisation or a sole trader looking to automate your business processes, or speed up your day-to-day business operations, or perform complex analyses on your company data, the cost will probably be a lot less than you think.</p>
        <p>Whether you want to run your own software on your own server, or have new apps built to run here on our website, then please contact us now to find out how we can help.</p>
    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/process-automation.jpeg" alt="" />
    </div>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
<div class="container" id="SaaS">
<!-- ============================================================================ -->
    <div class="content-image-small">
        <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/CUSTOM_SOFTWARE_DEVELOPMENT_001.png" alt="" />
    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/CUSTOM_SOFTWARE_DEVELOPMENT_001.png" alt="" />
    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <h2><!--WHAT, WHY-->Ready made business applications now freely available</h2>
        <p>We currently provide free off-the-shelf business software for use here on our website. This is often called software as a service (SaaS). We will always provide lots of useful business apps free of charge, and soon we will be opening our app store.</p>
        <p>SaaS apps mean that you don\'t need to have your own website to run your business software, or download applications to your computer. Also, our service enables you to choose only the apps and features you need.</p>
        <p>Our apps are available here on this website. All you need to do is

<!--<a href="' . $this->Registrar->Get('Config')->RootURL . '/crm/membership/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '" id="TML9">-->register<!--</a>-->

 - it takes just a few seconds, and your free apps will be available immediately from your app menu on the left-hand side of the page.</p>
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
/*
premium service...meticulous attention to detail...precise...for those who have suffered the pain of amateur services...and for those wanting to save money by avoiding amateurs in the first place...
*/
?>
