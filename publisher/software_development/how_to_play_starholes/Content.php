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

        <h2>How to play Starholes</h2>

        <p><iframe src="https://www.youtube.com/embed/QKOOodQwHRI?autoplay=1" frameborder="0" allowfullscreen></iframe>
</p>

        <!-- <p><a href="https://www.youtube.com/watch?v=QKOOodQwHRI" target="_new"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/STARHOLES_GAMEPLAY_00003.png" alt="" /></a></p> -->

        <h2>The essential gameplay for Starholes is now complete. So let\'s play! Read this quickstarter guide, and watch the video above. Watch carefully, the hand can be quicker than the eye!</h2>

        <h2>Contents</h2>

        <p>1. Introduction</p>

        <p>2. Key to the symbols</p>

        <p>3. Scoring algorithm</p>

        <h3>1. Introduction</h3>

        <p>First, watch me play Starholes in the YouTube video above. In the next section, you can have a go yourself. If you have any questions, then please contact me.</p>

        <!-- <p><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/STARHOLES_KEY_00001.png" alt="" style="width: 100%; height: 100%;" /></p> -->

        <h3>2. Key to the symbols</h3>

        <p>Missiles (white squares) and raiders (red squares) travel in straight lines from star to star, but not across the blue rectangles. Missiles are launched by tapping the blue \'FIRE\' button.</p>

        <p><b>Blue rectangles</b> = energy banks which cannot be traversed by missiles or raiders.</p>
     
        <p><b>Yellow circles</b> = star systems (i.e. solar systems). Red raiders pop out from the yellow circles at random.</p>
     
        <p><b>White squares</b> = missiles.</p>
     
        <p><b>White lines</b> = missile path. You plot missile paths by tapping on stars. Missile paths can be as long as you like, but remember, you can\'t traverse the blue rectangles. When you tap on the blue \'FIRE\' button to launch a missile, your missile travels along the path. Once a missile has been launched on its path, you may delete that path by tapping on the first white node from which the missile was launched. You may then start plotting another path for the next missile straight away while the missile you launched previously continues on its path. So, you do not need to wait for a missile to complete its journey before starting to plot a new missile path.</p>
     
        <p><b>White circles</b> = nodes on a missile path. When a node is tapped, the missile path is shortened to that node. So if you want to delete the entire current missile path, then just tap the first node.</p>
     
        <p><b>Blue \'FIRE\' button</b> =  used to fire missiles.</p>
     
        <p><b>Red  squares</b> = raiders. Raiders leech energy from your star sector. When a raider first appears, it will start to travel along a random path of stars and steal energy units from each star on its journey path. Therefore, a good strategy might be to try killing raiders before they reach their first star.</p>

        <p>Hey, that wasn\'t a bad score - but certainly not the best! Did you notice how nervous I was at times? And that\'s after playing two or three hundred games! Starholes is easy to learn and easy to play. Your average score will gradually improve, and every now and again you\'ll hit a new high score.</p>

        <p>Do you think you can beat my score? It might take you a few games, but I\'m sure you\'ll be able to do it soon enough! :D</p>

        <h3>3. Scoring algorithm</h3>

        <p>You have been employed as a mercenary to provide defence services to the government of our star sector.</p>

        <!-- <p>at any given time, we take the number of missiles minus the number of raiders, and multiply this by 20 points...</p> -->

        <p>You will be paid 20 points for each raider you kill. Your missiles cost 20 points each. Therefore, one of your main objectives must be to destroy more than one raider with each missile. This will be possible most of the time.</p>

        <p>Any particular raider has a list of target stars. You do not have access to this list. But you can see which star the raider is currently heading towards (i.e. its current target star). You must try to destroy that raider before it reaches its current target star.</p>

        <p>If a raider reaches one of its target stars, then it will steal 10 points from that star. As a result of this, the Energy value will decrease by 10 units.</p>

        <h3>Your wages</h3>

        <p>For each raider you kill: 20 points.</p>

        <h3>Deductions (expenses)</h3>

        <p>For each missile you use, deduct 20 points.</p>

        <p>For each leg of a missile\'s journey, deduct 1 point.</p>

        <p>At the end of the game, the energy which the government has lost should be deducted from your score. The remainder is your final score (your wages). Note that if you performed poorly, then your wages may be negative (i.e. you will have made a loss). To improve your skills, keep playing!</p>

    </div>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
</div>
<!-- ############################################################################ -->
';
        return $html;
    }
}
//####################################################################




































?>
