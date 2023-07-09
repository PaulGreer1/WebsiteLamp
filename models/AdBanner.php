<?php

class AdBanner
{
//====================================================================
    public $Registrar;

    // A user-defined set of banners available for display on the UI.

    public $AvailableBanners = array(
                                      array( '/media/testimonial_2.gif', 'https://www.peopleperhour.com/freelancer/david/php-mysql-magento/750623' ),
                                      array( '/media/testimonial_3.gif', 'https://www.peopleperhour.com/freelancer/david/php-mysql-magento/750623' ),
                                      array( '/media/discuss_project_3.gif', '/crm/contact_us/controller.php' ),
                                      array( '/media/ONE_PAGE_WEBSITE_001.png', '/crm/contact_us/controller.php' ),
                                      array( '/media/SIX_PAGE_WEBSITE_002.png', '/crm/contact_us/controller.php' ),
                                      array( '/media/TEN_PAGE_WEBSITE_001.png', '/crm/contact_us/controller.php' )
                                    );

    // The set of banners which will be displayed on the UI. This is a random subset of AvailableBanners.

    public $BannersForDisplay = array();

    // The number of banners to insert into BannersForDisplay. Must be less than or equal to the number of banners in the $AvailableBanners array above.

    public $NumberOfBannersToDisplay = 3;

//====================================================================
    // Constructor

    public function __construct( $inRegistrar )
    {
        $this->Registrar = $inRegistrar;
    }

//====================================================================
    // AdBanner::AdBanner

    public function AdBanner()
    {
        $html = '';

        // from the available banners, retrieve a subset which will be displayed on the web page...
        $BannerCount = 0;
        while( $BannerCount < $this->NumberOfBannersToDisplay )
        {
            $Banner = $this->AvailableBanners[ mt_rand( 1, count( $this->AvailableBanners ) ) - 1 ];
            if( ! in_array( $Banner, $this->BannersForDisplay, TRUE ) )
            {
                array_push( $this->BannersForDisplay, $Banner );
                $BannerCount = $BannerCount + 1;
            }
        }

        return $this->BannersForDisplay;

/******************************************************
The following is now defined in the view file RightPanel.php.

        // for each of the banners to be displayed, make the image into a hyperlink which points to the banner's corresponding target URL...
        foreach( $this->BannersForDisplay as $BannerAtts )
        {
            $LinkURL = '';
            $TargetURL = '';
            if( preg_match( '/^http.+/', $BannerAtts[1] ) )
            {
                $LinkURL = $BannerAtts[1];
                $TargetURL = 'new';
            }
            else
            {
                $LinkURL = $this->Registrar->Get('Config')->RootURL . $BannerAtts[1];
            }
            $html = $html . '<div class="topspek-inner-right-panel-1">
                             <a href="' . $LinkURL . '" target="' . $TargetURL . '">
                             <img style="box-shadow: 3px 3px 4px rgba(0,0,0,0.70); max-width: 499px; max-height: 222px;" src="' . $this->Registrar->Get('Config')->RootURL . $BannerAtts[0] . '" />
                             </a>';
        }

        return $html;
******************************************************/
//-------------------------------------------------
    }
//====================================================================
}
?>
