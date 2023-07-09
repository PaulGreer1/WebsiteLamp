<?php
//####################################################################
class LeftPanelList extends View
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

    public function LeftPanelList()
    {
        return '<div class="col-2 col-m-3 menu">
                    <ul>
                    <li><b>COMING SOON...</b></li>
                    <li>ONLINE...</li>
                    <li>...BUSINESS...</li>
                    <li>...APPLICATIONS</li>
                    </ul>
               </div>';
    }
}
//####################################################################
?>
