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
<!--
    <div class="content-article">

        <h1>We create and develop custom apps and games for Android and iOS touch-screen devices including mobile phones and tablets.</h1>

        <p>All of our apps and games are fully tested and scanned by Google, and can be installed by your customers or staff from the Google Play Store or Apple\'s App Store. We can also provide ongoing support, management and deployment of your apps and games on our Google Play Console.</p>

        <p>Just give us your ideas, and we will provide you with a complete system for their implementation, deployment and development.</p>

        <p>We also create multi-agent system simulations, which are very similar in nature to games, but are used more for modelling real-world processes and testing systems under varying conditions.</p>
-->
        <!-- <p>I develop my apps and games using Java within the Android Studio development environment. I use the Android framework and programming library to develop apps, and I use the LibGDX framework and programming library to develop games and simulations.</p> -->
<!--
    </div>
-->
<!-- ============================================================================ -->
    <div class="content-text">

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/mobile_apps/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/APPS_00001_460x320.png" alt="" /></a></p>

        <h2>Apps</h2>

        <h2>Make your mobile devices part of your business system</h2>

        <p>Use apps for customer relationships and business processes. Enable your customers and staff to install your apps from Google Play and Apple\'s App Store.</p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/mobile_apps/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>

    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_overview/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/GAMES_00001_460x320.png" alt="" /></a></p>

        <h2>Games</h2>

        <h2>Create an exciting video game for your customers</h2>

        <p>As well as unique, engaging gameplays, we can create beautiful art to depict your business themes and products whilst your customers play your game.</p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/mobile_games/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>

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
