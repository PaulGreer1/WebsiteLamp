<?php
//####################################################################
class Header extends View
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

    public function Header()
    {
        $html = '<div class="header">
                     <!--<div style="text-shadow:  3px 3px 4px rgba(0,0,0,0.70); text-align: center;">TopSpek</div>-->
                     <!--<div style="font-size: 23px; padding-bottom: 10px; text-align: center;"> Software Creation and Development</div>-->
                     <!--<div><img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/TOPSPEK_LOGO_005.png" style="height: 94px; width: 291px; /* float: right; margin-left: 20px; margin-top: 5px; */" /></div>-->
                     <!--<div><img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/TOPSPEK_LOGO_003.png" style="height: 93px; width: 291px; /* float: right; margin-left: 20px; margin-top: 5px; */" /></div>-->
                     <!--<div><img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/TOPSPEK_LOGO_006.png" style="height: 98px; width: 296px; /* float: right; margin-left: 20px; margin-top: 5px; */" /></div>-->
                     <!--<div><img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/TOPSPEK_LOGO_007.png" style="height: 97px; width: 295px; /* float: right; margin-left: 20px; margin-top: 5px; */" /></div>-->

                     <!--<div style="font-size: 15px; /*padding-bottom: 15px; text-align: left;*/" id="demo">LAUNCHING IN...</div>-->
                     <div><img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/TOPSPEK_LOGO_008.png" style="height: 97px; width: 293px; /* float: right; margin-left: 20px; margin-top: 5px; */" /></div>

<!--<script>
// Set the date we\'re counting down to
var countDownDate = new Date("Sep 01, 2019 00:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today\'s date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + " DAYS : " + hours + " H : " + minutes + " M : " + seconds + " S";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>-->

                 </div>';

        return $html;
    }
}
//####################################################################
?>
