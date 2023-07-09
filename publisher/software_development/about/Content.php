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

        <p><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/ABOUT_UKAPPCODER_00001_460x320.png" alt="" /></p>

        <h2>UkAppCoder mission statement</h2>

        <p>UkAppCoder will provide high quality software to facilitate business, pleasure and analysis through the creation and development of apps, games and system simulation programs for mobile devices.</p>

        <h2>UkAppCoder founder</h2>

        <p>David Mortimer BSc(Hons). Computer science, Mathematics, Systems Analysis. First Class.</p>

        <h2>At UkAppCoder, the following technology set is currently being used for software development.</h2>

        <table id="t1">
        <tr>
            <th colspan="2">Core technology set used at UkGameCoder</th>
        </tr>
        <tr>
            <td>Local development</td>
            <td>Linux Debian</td>
        </tr>
        <tr>
            <td>Apps and games</td>
            <td>The Java programming language within the Android Studio integrated development environment.</td>
        </tr>
        <tr>
            <td>Apps</td>
            <td>The Android framework and programming library.</td>
        </tr>
        <tr>
            <td>Games</td>
            <td>The LibGDX framework and programming library.</td>
        </tr>
        <tr>
            <td>Deployment of apps and games</td>
            <td>The Google Play Store and a Google Play Console.</td>
        </tr>
        <tr>
            <td>Webhosting</td>
            <td>Linux CentOS</td>
        </tr>
        <tr>
            <td>Web server</td>
            <td>Apache</td>
        </tr>
        <tr>
            <td>Database management system</td>
            <td>MySQL</td>
        </tr>
        <tr>
            <td>Web apps</td>
            <td>The PHP programming language.</td>
        </tr>
        </table><br />

        <p>...</p>

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
