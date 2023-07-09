<?php

class PageView
{
    public $Registrar;
    public $html = '';

    public function __construct( $inRegistrar )
    {
        $Interfaces = $inRegistrar->Get('Config')->DefaultInterfaces;
        $ExtraInterfaces = array();
        foreach( $ExtraInterfaces as $ExtraInterface )
        {
            array_push( $Interfaces, $ExtraInterface );
        }
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

    public function GenerateView( $inRegistrar )
    {
        $Header = new Header( $inRegistrar );
        $Topmenu = new Topmenu( $inRegistrar );
        $LeftPanelList = new LeftPanelList( $inRegistrar );
        $RightPanel = new RightPanel( $inRegistrar );
        $Footer = new Footer( $inRegistrar );

        $html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                  <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

                  <head>
                      <title>Expert Magento Developer Available For Hire</title>

                      <!--<link rel="stylesheet" type="text/css" href="' . $inRegistrar->Get('Config')->RootURL . '/STYLESHEET.css" />-->
                      <!--<link rel="stylesheet" media="screen and (min-width: 500px) and (max-width: 768px)" href="STYLESHEET.css" />-->
                      <link rel="stylesheet" media="screen and (min-width: 510px)" href="' . $inRegistrar->Get('Config')->RootURL . '/STYLESHEET.css" />
                      <link rel="stylesheet" media="screen and (max-width: 510px)" href="' . $inRegistrar->Get('Config')->RootURL . '/STYLESHEET_2.css" />

                      <!--<link rel="shortcut icon" href="https://localhost/Images/favicon.ico" />-->
                      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                  </head>
                  <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                  <body>' .

                  $Header->Header() .
                  $Topmenu->Topmenu() .

                  '<div class="row">' .

                      $LeftPanelList->LeftPanelList() .

                      '<div class="col-6 col-m-8">

                          <h1>Portfolio</h1>

                          <div class="copy">

                          <p>The following is a short selection from the many Magento projects that I have completed.</p>

                          <p><a href="http://www.buttonandsprung.com" target="new">www.buttonandsprung.com</a> - Did quite a bit of work on this site early last year. Connected parts of the frontend to backend and database functions. Built a pretty complex \'guest wishlist\' extension which enables guest visitors to keep a wishlist without being logged in. Magento requires visitors to sign up to the site before letting visitors open a wishlist. My extension uses cookies to remember guests and let them keep wishlists without signing up. Also did quite a bit of very complicated bug-fixing for this site.</p>

                          <p><a href="http://www.missluxe.co.uk" target="new">missluxe.co.uk</a> - Have completed many various tasks for this firm including some very complex bug-fixing on third party extensions. Third party extension customisation and fixing can be very difficult because there is hardly ever any documentation, that is, very often raw source code needs to be studied in order to learn about the system and thus track down bugs.</p>

                          <p><a href="http://www.stovey.co.uk" target="new">stovey.co.uk</a> - Again, I connected frontend widgets to backend code and database queries. In particular, there is a map of Britain on the site somewhere which has all the postcodes to which stovey\'s salesmen are designated. I had to create the system which related salesmen, commissions, postcodes, etc.. I also did some complex mathematical work which calculated sales commissions, VAT, etc..</p>

                          <p><a href="http://www.bhspares.com" target="new">bhspares.com</a> - I upgraded bhspares from a non-responsive version of Magento to being responsive. I used the Ultimo theme. The design and layout is now a little different from that which I provided. They asked me to do the extra work sometime after the first project, but at the time I was just too busy.</p>

                          <p><a href="http://www.johnnewtondriving.co.uk" target="new">johnnewtondriving.co.uk</a> - Built this site for a driving instruction firm. It is still very simple at the moment, but I think they intend to develop it so they can sell driving lessons as \'products\', and take bookings and payments online - which is why they wanted to use Magento.</p>

                          </div>

                      </div>' .

                      $RightPanel->RightPanel() .

                  '</div>' .

                  $Footer->Footer() .

                  '</body></html>';

        echo $html;
    }
}

?>
