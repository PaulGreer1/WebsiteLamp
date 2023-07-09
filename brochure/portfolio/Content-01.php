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
<div class="container" id="CustomerCredit">

    <div class="content-text" style="width: 100%; min-height: 0px; background-color: #ffffff;">
        <h1><!--WHO. WHERE. WHY. WHAT.-->A selection of our PHP and MySQL projects</h1>
    </div>

<!-- ============================================================================ -->
    <div class="content-image-small">
        <a href="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/topspek-credit-control-003.png">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/credit-013.jpg" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <h3>TopSpek\'s customer credit tracking system</h3>

        <p>TopSpek Credit is a comprehensive customer credit tracking system which enables firms to track and control credit extended to their customers.</p>

        <p>The main console includes summaries of credit data, statements currently on credit, overdue statements and overdue statements which require checking. Other panels can also be accessed from the main console, including a staff admin panel, a statement and invoice admin panel, and a customer admin panel.</p>

        <p>The staff admin panel can be used to add, update and delete staff members. The statement and invoice admin panel lists all the invoices on a statement and enables admin staff to record partial and full invoice payments and write-offs. This panel also displays a payment log and a timestamped list of statement notes added by staff members. The customer admin panel enables admin staff to add and delete customers or update customer details.</p>

        <p>The system automatically sends various email notifications to remind customers of impending payments, overdue payments, etc..</p>

        <p>This powerful application is now available from our website - sign up now!</p>

    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <!-- <a href="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/topspek-credit-control-003.png"> -->
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/credit-013.jpg" alt="" />
        <!-- </a> -->
    </div>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
<div class="container" id="ButtonSprung">
<!-- ============================================================================ -->
    <div class="content-image-small">
        <a href="https://www.buttonandsprung.com/">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/b&amp;s-bed-001.png" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <a href="https://www.buttonandsprung.com/">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/b&amp;s-bed-001.png" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <h3>A guest wishlist Magento extension for Button&amp;Sprung</h3>

        <p>Button&amp;Sprung sell bedding products via a Magento ecommerce website.</p>

        <p>The standard Magento distribution has a \'wishlist\' feature, but requires visitors to register with the website before allowing them to use it. Button&amp;Sprung wanted their guest visitors to be able to use their wishlist facility without them having to register as a members.</p>

        <p>TopSpek solved this problem by creating a brand new custom \'guest wishlist\' extension so that all visitors can keep a wishlist without being logged in. Our extension uses cookies to remember guests.</p>

        <p>We also did quite a lot of complicated bug-fixing for this website, along with other tasks such as the connection of frontend widgets to backend functions which access the Magento database.</p>

    </div>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
<div class="container" id="BGLGolf">
<!-- ============================================================================ -->
    <div class="content-image-small">
        <a href="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/bgl-opal-003.png">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/bgl-opal-001.png" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <h3>Standalone application and database extension for BGL Golf</h3>

        <p>BGL-Opal sells various products which are customised for various golf \'business locations\' around the UK.</p>

        <p>BGL-Opal asked us to create a separate support application, with its own user interface, functions and relational database. The new application was required to collaborate with their main application and its database in order to perform various supporting tasks.</p>

        <p>Our new database provides data which are combined with data from the main database in order to provide extra supporting functions and information for the system. For example, each business location is given an annual budget to spend on products sold from the main website. One of the requirements of our new application was to track the orders made by the various business locations, and make all the calculations necessary to provide information in the form of reports, and also keep track of the budgets remaining for the business locations.</p>

    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <a href="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/bgl-opal-003.png">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/bgl-opal-001.png" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
<div class="container" id="Stovey">
<!-- ============================================================================ -->
    <div class="content-image-small">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/stovey-001.jpg" alt="" />
    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/stovey-001.jpg" alt="" />
    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <h3>Complex calculators created and integrated into Stovey software</h3>

        <p>Stovey manufactures and sells high quality wood-burning stoves.</p>

        <p>We completed various tasks on the Stovey site, including some complex calculator functions related to sales, commissions, tax, VAT, etc..</p>

        <p>We also extended the functionality of the site to include a map of Britain showing all the postcodes to which Stovey\'s salesmen are designated, along with links from the regions on this map to sales dashboards which give information about the salespeople, their commissions, sales areas, etc..</p>

        <p>No documentation was available for any of the existing programs, and so we had to spend many hours reading and tracing through complex source code in order to ensure that our code was integrated seamlessly into the existing application.</p>

    </div>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
<div class="container" id="FabelleLondon">
<!-- ============================================================================ -->
    <div class="content-image-small">
        <a href="https://fabelle-london.com/">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/fabelle-001.png" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <h3>A custom Magento extension  which implements a sliding discount calculator for Fabelle London</h3>

        <p>Fabelle London sells and ships various forms of formal and casual footwear to customers around the world.</p>

        <p>Fabelle asked us to create a new Magento extension which implements a sliding discount calculator. This extension had to be incorporated into the client\'s main website.</p>

        <p>Although the underlying maths for sliding discounts is fairly straightforward, the calculation was complicated by various factors in the existing system. For example, international regions have their own shipping charges and this affected the calculations.</p>

        <p>We also needed to add new international locations to the system, and we needed to work on layout and design aspects in order to update the existing user interfaces so that they would accept new inputs.</p>

        <p>Existing related functions in the system\'s codebase also had to be modified in order to accommodate our new functionality. Database restructuring was also necessary.</p>

    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <a href="https://fabelle-london.com/">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/fabelle-001.png" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
</div>
<!-- ############################################################################ -->
<div class="container" id="JohnNewtonDriving">
<!-- ============================================================================ -->
    <div class="content-image-small">
        <a href="https://johnnewtondriving.com">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/john-newton-driving-001.jpg" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
    <div class="content-image">
        <a href="https://johnnewtondriving.com">
        <img src="' . $this->Registrar->Get('Config')->RootUrl . '/media/images/john-newton-driving-001.jpg" alt="" />
        </a>
    </div>
<!-- ============================================================================ -->
    <div class="content-text">

        <h3>A 10-page brochure website for a local driving school</h3>

        <p>We include this simple low budget website to show that no project is too small for TopSpek.</p>

        <p>John Newton is a hard-working driving instructor who works in our region. When we first met John, he was paying around £55 per week for a basic website of questionable quality.</p>

        <p>At the time, John was 72 years of age, and was unaware that he was being overcharged - all he really needed to be paying was around £12 per month.</p>

        <p>John was clearly being deceived, and so we agreed to create a website for him for just £200 - no strings attached and certainly no ongoing payments. We also arranged webhosting for him and took care of his domain name transfer.</p>

        <p>We are very happy to report that so far to date (' . date( 'M Y' ) . '), John has saved over £10,000 in hard cash, which is in his bank account instead of theirs!</p>

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

?>
