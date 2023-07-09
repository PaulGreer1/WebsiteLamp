<?php

class PageView extends View
{
    public $Registrar;
    public $html = '';
    private $Title = 'Software Engineering | Programming | Coding';

    public function __construct( $inRegistrar, $inTitle )
    {
        $this->Title = $inTitle;
        $Interfaces = $inRegistrar->Get('Config')->DefaultInterfaces;
        $ExtraInterfaces = array();
        foreach( $ExtraInterfaces as $ExtraInterface )
        {
            array_push( $Interfaces, $ExtraInterface );
        }
        parent::__construct( $inRegistrar, $Interfaces );
    }

    public function GenerateView( $inRegistrar )
    {
        $Header = new Header( $inRegistrar );
        $Topmenu = new Topmenu( $inRegistrar );
        $LeftPanel = new LeftPanel( $inRegistrar );
        $Content = new Content( $inRegistrar );
        $RightPanel = new RightPanel( $inRegistrar );
        $Footer = new Footer( $inRegistrar );

        $this->html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                  <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

                  <head>
                      <title>' . $this->Title . '</title>

                      <!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />-->

                      <!--<link rel="stylesheet" type="text/css" href="' . $inRegistrar->Get('Config')->RootURL . '/STYLESHEET.css" />-->
                      <!--<link rel="stylesheet" media="screen and (min-width: 500px) and (max-width: 768px)" href="STYLESHEET.css" />-->
                      <link rel="stylesheet" type="text/css" href="' . $inRegistrar->Get('Config')->RootURL . '/STYLESHEET_COMMON.css" />
                      <link rel="stylesheet" media="screen and (max-width: 610px)" href="' . $inRegistrar->Get('Config')->RootURL . '/STYLESHEET_TOPMENU_ACCORDION.css" />
                      <link rel="stylesheet" media="screen and (min-width: 610px)" href="' . $inRegistrar->Get('Config')->RootURL . '/STYLESHEET_TOPMENU_BAR.css" />

                      <!--<link rel="shortcut icon" href="https://localhost/Images/favicon.ico" />-->
                      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                      <meta name="viewport" content="width=device-width, initial-scale=1.0" />

                  <link rel="shortcut icon" type="image/png" href="' . $inRegistrar->Get('Config')->RootURL . '/media/images/TOPSPEK_THOUGHT_BUBBLE_005.png" />



                  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" /> -->
                  <!-- <link rel="stylesheet" href="/resources/demos/style.css" /> -->
<!--
                  <script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
                  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
                  <script type="text/javascript">
                      $( function()
                         {
                             $( "#datepicker" ).datepicker({ dateFormat: "dd-mm-yy" }).datepicker( "setDate", "0" );
                         } );
                      $( function()
                         {
                             $( "#datepicker2" ).datepicker({ dateFormat: "dd-mm-yy" }).datepicker( "setDate", "0" );
                         } );
                      $( function()
                         {
                             $( "#datepicker3" ).datepicker({ dateFormat: "dd-mm-yy" }).datepicker( "setDate", "0" );
                         } );
                      $( function()
                         {
                             $( "#datepicker4" ).datepicker({ dateFormat: "dd-mm-yy" }).datepicker( "setDate", "0" );
                         } );
                      $( function()
                         {
                             $( "#datepicker5" ).datepicker({ dateFormat: "dd-mm-yy" }).datepicker( "setDate", "0" );
                         } );
                      $( function()
                         {
                             $( "#datepicker6" ).datepicker({ dateFormat: "dd-mm-yy" }).datepicker( "setDate", "0" );
                         } );
                      $( function()
                         {
                             $( "#datepicker7" ).datepicker({ dateFormat: "dd-mm-yy" }).datepicker( "setDate", "0" );
                         } );
                  </script>
-->
                  </head>

                  <body>' .

                      '<div class="header">' .
                          $Header->Header() .
                      '</div>' .

                      '<div class="topmenubar">' .
                          $Topmenu->Topmenu() .
                      '</div>' .

                      '<div class="topspek-left-panel">' .
                          $LeftPanel->LeftPanel() .
                      '</div>' .

                      '<div class="topspek-content-panel">' .
                           $Content->Content() .
                      '</div>' .

                      '<div class="topspek-right-panel">' .
                          $RightPanel->RightPanel() .
                      '</div>' .

                      '<div class="footer">' .
                          $Footer->Footer() .
                      '</div>' .

                  '</body></html>';

        echo $this->html;
    }
}

?>
