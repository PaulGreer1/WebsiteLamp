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

        <h2>Custom apps and games for Android/iOS devices: phones, tablets, etc.</h2>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/mobile_apps/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/APPS_00002.jpg" alt="" /></a></p>

        <h3>All of our apps are fully tested and scanned, and can be installed by your customers or staff from the Google Play Store or Apple\'s App Store. We can also provide ongoing management, support and development of your apps on our Google Play Console.</h3>

        <p>Over the last 21 years, I have worked on many different kinds of software including financial apps, data analysis, charting, distributed databases, network programming and graphical information systems.</p>

<!--
        <h3>App examples: the ReadyReckoners project (includes free app downloads)</h3>

        <p><a href="' . $this->Registrar->Get('Config')->RootURL . '/publisher/software_development/readyreckoners_project/controller.php' . '?' . $this->Registrar->Get('QueryStringInputs') . '"">The ReadyReckoners project</a></p>
-->

        <h3>Our products and services</h3>

        <p>There are many reasons why a business might want to have an app created. We can implement your ideas, and we can also suggest many new ideas.</p>

        <h3>Database apps</h3>

        <p>Powerful database apps are no longer exclusive to big companies with big budgets. I am an expert in relational database design and implementation, and I have strong SQL and coding skills. This means we can create apps and databases for powerful data analyses as well as everyday business operations.</p>

        <h3>Communications</h3>

        <p>We can provide apps which communicate with other systems on the network. This enables apps to send news, information and notifications about your products, deliveries, discounts, etc., directly to the phones and desktops of your customers.</p>

        <p>Apps can enable your customers to contact you via forms instead of phoning you. Tools like this can be fully automated. Many customers find this means of communication more convenient.</p>

        <p>As well as improving customer relationships, our apps can also enable your colleagues and staff to communicate more efficiently.</p>

        <h3>Simple tools</h3>

        <p>Some apps are very simple and inexpensive, but could be highly effective in helping your customers and staff. For example, the humble brochure can be a highly cost-effective tool for any business. Or how about a trade calculator which helps your customers with their work. Again, you could be advertising your products as you help your customers.</p>

        <p>No doubt you have far more ideas than we do about how you could use custom apps to improve your business. Why not contact us to discuss your ideas with us? The costs will probably be a lot less than you imagine.</p>

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
