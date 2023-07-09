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
        $html = '<a href="https://www.twitter.com/topspek" target="blank1" style="text-decoration:none">
                 <img style="max-width: 40px; max-height: 40px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/TWITTER_ICON_001.png" />
                 </a>
                 <a href="https://www.facebook.com/topspek" target="blank2" style="text-decoration:none">
                 <img style="max-width: 40px; max-height: 40px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/FACEBOOK_ICON_001.png" />
                 </a>
                 <a href="https://www.linkedin.com/in/david-m-531838189/" target="blank3" style="text-decoration:none">
                 <img style="max-width: 40px; max-height: 40px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/LINKEDIN_ICON_001.png" />
                 </a>
                 <!--<a href="https://www.trustpilot.com/review/topspek.com?languages=all" target="blank4" style="text-decoration:none">
                 <img style="max-width: 40px; max-height: 40px;" src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/TRUSTPILOT_002.png" />
                 </a>--><br /><br />';

        $html = $html . '<div class="topspek-inner-right-panel-1">
                         <div style="font-size: 15px; /*padding-bottom: 15px; text-align: left;*/" id="demo">LAUNCHING IN...</div>
                         </div><br />';

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
            $html = $html . '<div class="topspek-inner-right-panel-1">
                             <a href="' . $LinkURL . '" target="' . $TargetURL . '">
                             <img style="' /*. 'box-shadow: 3px 3px 4px rgba(0,0,0,0.70);'*/ . ' max-width: 499px; max-height: 222px; display: block; margin: auto;" src="' . $this->Registrar->Get('Config')->RootURL . $BannerAtts[0] . '" />
                             </a>
                             </div><br />';
        }

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

        return $html;

/*
        $html = $this->Registrar->Get('AdBanner');
		return $html;
*/
    }
}
//####################################################################
?>
