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
        $html = '
<!-- ############################################################################ -->
<div class="content-panel">
<!-- ############################################################################ -->
<div class="container">
<!-- ============================================================================ -->
    <div class="content-article">

        <h2>Starholes</h2>

        <p>Please visit the Google Play Store for a live demonstration of my own unique video game built with Java/libGDX. Install it now from the Google Play Store - it\'s free!</p>

        <p><a href="https://play.google.com/store/apps/details?id=com.ukgamecoder.starholes" target="_new">Starholes</a></p>

        <p>Think about how you could customise my game for your own needs.</p>

    </div>

<!-- ============================================================================ -->
<!--

    <div class="content-text">

        <form action="https://www.paypal.com/donate" method="post" target="_top">
            <input type="hidden" name="hosted_button_id" value="LXCEGJFVLHVSU" />
            <input type="image" src="https://www.ukgamecoder.com/media/images/DEFENDERBOT_00007.png" width="100" height="60" border="2" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
            <img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
        </form>

        <form action="https://www.paypal.com/donate" method="post" target="_top">
            <input type="hidden" name="hosted_button_id" value="LXCEGJFVLHVSU" />
            <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
            <img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
        </form>

    </div>

-->
<!-- ============================================================================ -->
    <div class="content-text">

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_description/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/STARHOLES_APP_ICON_00001_460x320.png" alt="" /></a></p>

        <h2>Got a few minutes to kill? Then reach for your phone and wave bye-bye to boredom!</h2>

        <p>Starholes is a family game which is great to play at any time, and is perfect for those times when you have a few minutes to kill. </p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_description/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>

    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <!-- <p style="text-align: center;"><iframe width="274" height="160" src="https://www.youtube.com/embed/QKOOodQwHRI?autoplay=1" frameborder="0" allowfullscreen></iframe>
</p> -->

        <!-- <p style="text-align: center;"><iframe width="274" height="160" src="https://www.youtube.com/embed/YYOKMUTTDdA?autoplay=1" frameborder="0" allowfullscreen></iframe>
</p> -->

        <!-- <p><a href="https://www.youtube.com/watch?v=QKOOodQwHRI" target="_new"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/STARHOLES_GAMEPLAY_00003.png" alt="" /></a></p> -->

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/how_to_play_starholes/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/GAMEPLAY_SCREENSHOT_00004.png" alt="" /></a></p>

        <h2>How to play Starholes. Read this quickstart guide, and watch an action gameplay video</h2>

        <p>Understanding how to play Starholes is easy. Each game lasts for about 3 or 4 minutes. After about ten games, you\'ll start to get the hang of it.</p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/how_to_play_starholes/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>

    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <p><a href="https://play.google.com/store/apps/details?id=com.ukgamecoder.starholes" target="_new"><img alt="Get it on Google Play" src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" /></a></p>

        <h2>Google\'s rigorous testing and scanning of Starholes is now complete</h2>

        <p>You can play Starholes right now. Just click on the image above to go to my Google Play Store page and install it for free.</p>

        <!--<p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_is_on_google_play/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>-->

    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/art_and_science/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/DEFENDERBOT_FLANKED_BY_TWO_RAIDERBOTS.jpg" alt="" /></a></p>

        <h2>Starholes artworks involve no digital manipulation. <!-- View some of my art on my <a href="https://www.deviantart.com/ukgamecoder/gallery/all" style="color: #000000;" target="_new">DeviantArt page.</a> --></h2>

        <p>Defender bots, attack bots, wormholes, etc. - all expressed with beautiful artworks created with traditional media.</p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/art_and_science/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>

    </div>
<!-- ============================================================================ -->
<!--
    <div class="content-text">

        <p><a href="https://youtu.be/h6MBHVUI1Hw" target="_new"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/APRIL_STARHOLES_PRESENTATION_0001.png" alt="" /></a></p>

        <h2>Click on the image to spend one minute with April to find out more about our project</h2>

        <p>One of the great things about Starholes is that the gameplay is very  different to that of most other games, but it is very easy for anyone to  learn.</p>

        <p>Gamers are crying out for something different. Starholes is not only a highly entertaining game in its own right, it also provides a sound basis for a whole new gaming paradigm!</p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '">Contact April</a></p>
        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '">Read more...</a></p>

    </div>
-->
<!-- ============================================================================ -->
<!--
    <div class="content-text">

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/support_starholes/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/GROWTH_0001.png" alt="" /></a></p>

        <h2>Receive rewards in return for supporting the development of Starholes</h2>

        <p>For as little as £1, you can get involved in the future development of Starholes. <a href="' . $this->Registrar->Get('Config')->RootURL . '/crm/contact_us/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '" style="color: #000000;">Contact me</a></p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/support_starholes/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>

    </div>
-->
<!-- ============================================================================ -->
<!--
    <div class="content-text">

        <p style="text-align: center;"><iframe width="274" height="160" src="https://www.youtube.com/embed/YYOKMUTTDdA?autoplay=1" frameborder="0" allowfullscreen></iframe>
</p>

        <h2>Test YouTube video</h2>

        <p>Test YouTube video</p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/about_david_mortimer/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>

    </div>
-->
<!-- ============================================================================ -->
<!--
    <div class="content-text">

        <h2>The science fiction</h2>

        <p>The year is 424242. Instantaneous transportation between the star systems of our galaxy has long been possible by creating wormholes.</p>

        <p>The fundamental fabric of space consists of cells. These cells can be visualised as infinitesimally small 3D \'pixels\' on an infinite 3D monitor.</p>

        <p>A pixel on a computer display can appear to be moving, but this is just an illusion. What really happens is that a succession of contiguous pixels change state. At the very same moment as one pixel changes state, the next pixel changes state.</p>

        <p>A wormhole is a 3D pixel that has been stretched out to become contiguous with another pixel somewhere else in the universe. Multi-pixel wormholes can be created by taking a cluster of neighboring 3D pixels in one star sector, and stretching them out to another star sector.</p>

        <p>Star systems use wormholes to send raiders to each other\'s systems to steal energy. Some star systems have begun to form alliances to strengthen their defences. These alliances are called star sectors.</p>

        <p>Each star sector has one or more defenders. In the current star sector setting of our Starholes simulation, there is just one defender, but we will soon need to employ more defenders as the number of raids from other star sectors increases.</p>

    </div>
-->
<!-- ============================================================================ -->
<!--
    <div class="content-text">

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_description/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/GAMEPLAY_SCREENSHOT_00004.png" alt="" /></a></p>

        <h2>Starholes - your daily 5-minute adrenaline blast!</h2>

        <p>Starholes is addictive white knuckle action! Don\'t scratch that itch otherwise you could lose a precious second and miss your target!</p>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_description/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '">Read more...</a></p>

    </div>
-->
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
<!-- ############################################################################ -->

<!-- ============================================================================ -->
<!--
    <div class="content-article">

        <p style="text-align: center;"><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/starholes_overview/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"  style="color: #000000;"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/DEFENDERBOT_00007.png" alt="" /></a></p>

        <h2>Got a few minutes to kill? Then reach for your phone and wave bye-bye to boredom!</h2>

        <p>Starholes is a new touch-screen video game for mobile devices (phones, tablets, etc.). It is a family game which is easy to learn and fun to play at any time. Currently, a typical game lasts for around three or four minutes.</p>

        <p>The Starholes gameplay is unique. It is not a repetitive screen-tapping game with a never ending obstacle course. Starholes has not been built with a software builder program such as Unity. The gameplay is based on our unique mathematical modelling.</p>

        <p>Starholes has been fully tested and scanned by Google, and is now available as a free download from Google Play.</p>

    </div>
-->
<!-- ============================================================================ -->

<!-- ############################################################################ -->
</div>
<!-- ############################################################################ -->
';
        return $html;
    }
}
//####################################################################
?>
