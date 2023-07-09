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

        <h2>Custom games for Android/iOS devices: phones, tablets, etc.</h2>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_overview/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/GAMES_00005_430x320.png" alt="" /></a></p>

        <h3>Engage your customers with an exciting video game. Use your products and services as the theme for your game. Advertise your business to your customers whilst entertaining them. Who said that watching commercials can\'t be an entertaining experience?!</h3>

        <p>Our own proprietary game engine enables us to produce unique gameplays. Our game Starholes is currently running with a space-wars theme, but could have many other different themes. Check it out. You could probably think of a theme which reflects the nature of your own business.</p>

        <p>And games are not just for entertainment. The same technologies and programming techniques can model a wide variety of real-world business processes. Run simulations of various systems with different variables. Simulate systems with groups or crowds of independent agents interacting within an overall system. Adjust variables and settings to get an idea of what will happen over time.</p>

        <h3>Game example: the Starholes project (includes free game download)</h3>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_project/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">The Starholes project</a></p>

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
