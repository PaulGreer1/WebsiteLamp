<?php
//####################################################################
class RightPanel extends View
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

    public function RightPanel()
    {
        $html = '<div class="right-panel">';

        $html .= '<div class="side-panel-box">
                  <p>Right panel, box 1</p>
                  <p>...</p>
                  </div>';

        $html .= '<div class="side-panel-box">
                  <p>Right panel, box 2</p>
                  <p>...</p>
                  </div>';

        $html .= '</div>';

/*
        // Display some ad banners. For each of the banners to be displayed, make the image into a hyperlink which points to the banner's corresponding target URL.
        foreach( $this->Registrar->Get('AdBanner') as $BannerAtts )
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
                $LinkURL = $this->Registrar->Get('Config')->RootURL . $BannerAtts[1] . '?' . $this->Registrar->Get('QueryStringInputs');
            }
            $html .= '<div class="right-panel">
                             <a href="' . $LinkURL . '" style="target-name: new;">
                             <img src="' . $this->Registrar->Get('Config')->RootURL . $BannerAtts[0] . '" alt="" />
                             </a>
                             </div>';
        }
*/
        //$html .= '<img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/valid-xhtml10.png" style="max-height: 31px; max-width: 88px;" alt="Valid XHTML 1.0" />';


        return $html;
    }
}

//####################################################################
//===============================================================
        // SOCIAL MEDIA LINKS
/*
        $html .= '<a href="https://www.twitter.com/topspek" style="text-decoration: none; target-name: new;">
                 <img style="max-width: 40px; max-height: 40px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/TWITTER_ICON_001.png" alt="" />
                 </a>
                 <a href="https://www.facebook.com/topspek" style="text-decoration:none; target-name: new;">
                 <img style="max-width: 40px; max-height: 40px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/FACEBOOK_ICON_001.png" alt="" />
                 </a>
                 <a href="https://www.linkedin.com/in/david-m-531838189/" style="text-decoration:none; target-name: new;">
                 <img style="max-width: 40px; max-height: 40px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/LINKEDIN_ICON_001.png" alt="" />
                 </a>';
*/
        //===============================================================
        // AD BANNERS
/*
        // Display some ad banners. For each of the banners to be displayed, make the image into a hyperlink which points to the banner's corresponding target URL.
        foreach( $this->Registrar->Get('AdBanner') as $BannerAtts )
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
                $LinkURL = $this->Registrar->Get('Config')->RootURL . $BannerAtts[1] . '?' . $this->Registrar->Get('QueryStringInputs');
            }
            $html .= '<div class="topspek-inner-right-panel-1">
                             <a href="' . $LinkURL . '" style="target-name: new;">
                             <img src="' . $this->Registrar->Get('Config')->RootURL . $BannerAtts[0] . '" alt="" />
                             </a>
                             </div>';
        }

        //$html .= '<img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/valid-xhtml10.png" style="max-height: 31px; max-width: 88px;" alt="Valid XHTML 1.0" />';
*/
        //===============================================================
        //===============================================================
        // COUNTDOWN CLOCK
/*
        $html .= '<div class="topspek-inner-right-panel-1">
                         <div style="font-size: 15px; padding-bottom: 15px; text-align: left;" id="demo">LAUNCHING IN...</div>
                         </div><br />';

        $html .= '<script>
                  var countDownDate = new Date("Oct 01, 2019 00:00:00").getTime();
                  var x = setInterval(
                  function()
                  {
                      var now = new Date().getTime();
                      var distance = countDownDate - now;
                      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                      document.getElementById("demo").innerHTML = "Memberships available in...<br /><br />" + days + " DAYS : " + hours + " H : " + minutes + " M : " + seconds + " S";
                      if( distance < 0 )
                      {
                          clearInterval(x);
                          document.getElementById("demo").innerHTML = "EXPIRED";
                      }
                  }, 1000);
                  </script>';
*/
        //===============================================================

/*
        $html = $this->Registrar->Get('AdBanner');
		return $html;
*/
//####################################################################
?>
