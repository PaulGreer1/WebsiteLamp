<?php
//####################################################################
class Footer extends View
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

    public function Footer()
    {
        $html = '';

//            $html .= '<br /><img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/valid-xhtml10.png" style="max-height: 31px; max-width: 88px;" alt="Valid XHTML 1.0" />';

//            $html .= '<img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/vcss-blue.gif" style="max-height: 31px; max-width: 88px;" alt="Valid XHTML 1.0" /><br /><br />';

//        $html .= '<img style="max-width: 25px; max-height: 25px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/TOPSPEK_THOUGHT_BUBBLE_001.png" alt="" /><br />

//        $html .= '<a href="https://twitter.com/UkGameCoder" target="_new" style="text-decoration: none; target-name: new;">
//                 <img style="max-width: 40px; max-height: 40px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/TWITTER_ICON_001.png" alt="" />
//                 </a><br />';

//        $html .= '__________________________________<br />';

        $html .= 'Copyright ' . date('Y') . '. www.ukappcoder.com';

        return $html;
    }
}
//####################################################################
?>
