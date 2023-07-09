<?php

class View
{
	// If an interface has been overridden in the same directory as the module's controller.php file, then
	// use the override, otherwise use the default interface in the interfaces directory...

    public function __construct( $inRegistrar, $Interfaces = array() )
    {
        foreach( $Interfaces as $Interface )
        {
            if( file_exists( $Interface ) )
            {
                include $Interface;
            }
            else
            {
                include $inRegistrar->Get('Config')->InterfacesDir . '/' . $Interface;
            }
        }
    }
}

?>
