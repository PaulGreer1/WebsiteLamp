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
        return '<div class="copy">
                    <p>Default output for the homepage content section of ' . $this->Registrar->Get('Config')->RootURL . '.</p>
					<p>Please note that some topmenu links may not work yet because some apps may not yet be installed. This is normal.</p>
                    <p>To override this message with your own content for this page, copy this Content.php file into your module\'s root directory and edit as required.</p>
					<p>TopSpekMvc 1.0 - providing a fast, secure and extensible MVC web application development framework where optimisation begins with design.</p>
					<p>Read about it at <a href="http://topspek.com/publisher/the_topspek_mvc_webapp_framework/controller.php" target="_new">here.</a></p>
                </div>';
    }
}
//####################################################################
?>
