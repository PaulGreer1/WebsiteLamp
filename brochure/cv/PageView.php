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
                      <title>David Mortimer\'s CV</title>

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

                          <h1>David Reed\'s CV</h1>

                          <div class="copy">

                          <p><b>Profile</b></p>

                          <p>I have worked in many different areas of software development, mainly within engineering and programming, in both the database and application domains.</p>

                          <p>Fresh challenges and opportunities to learn new skills are always most welcome. I have many goals and a determined nature. I like to theorise as I work, and am always on the lookout for principles and rules which may apply to different kinds of task. I find that this improves overall efficiency because concepts and techniques invented or discovered during one particular task can often be extrapolated to other task types.</p>

                          <p><b>Education</b></p>

                          <p>BSc (Hons).  Computer Science ~ Mathematics ~ Systems Analysis. The Open University, 2004 - 2011. First Class.</p>

                          <p>Over seven years, I combined my degree studies with work. I found that the two activities naturally complemented each other - my work determining the modules that I needed to study, and the modules often suggesting the type of work that I would be most interested in. The following is a selection of some of the subjects I studied.</p>

                          <p>Computer Science</p>

                          <p>Relational databases: theory and practice</p>

                          <p>Data requirements analysis ~ Relational theory ~ Entity relationship modelling ~ Logical schema creation ~ Referential integrity ~ Normal forms ~ Database design and implementation ~ SQL ~ Constraints</p>

                          <p>Modelling computer processes</p>

                          <p>Finite automata ~ Automata with memory ~ Language and grammar creation ~ Reasoned programming ~ Object interaction ~ Concepts of concurrency ~ Programming concurrency ~ Threads</p>

                          <p>Computing: an object oriented approach</p>

                          <p>Classes and objects ~ Inheritance ~ Modelling, designing and implementing software systems ~ Structural models ~ Invariants ~ Computing and networks</p>

                          <p>Building blocks of software</p>

                          <p>Data types ~ Sets ~ Binary trees ~ Formal logic ~ Pre-, mid- and post-conditions ~ Rules of inference ~ Recursion ~ Algorithm efficiency ~ Mathematical induction ~ Recurrence systems</p>

                          <p>Mathematics</p>

                          <p>Exploring mathematics</p>

                          <p>Sequences ~ Conics ~ Matrix transformations ~ Calculus ~ Taylor polynomials ~ Complex numbers ~ Number theory ~ Groups ~ Proof and reasoning</p>

                          <p>Using mathematics</p>

                          <p>Functions ~ Modelling with sequences, matrices and vectors ~ Differential equations ~ Growth and decay ~ Chance ~ Variation ~ Estimating</p>

                          <p>Systems analysis</p>

                          <p>Understanding system complexity</p>

                          <p>Mess analysis ~ Cause and effect ~ Positive feedback loops ~ Dynamic equilibrium ~ Chaos ~ Lag ~ Control loops ~ System dynamics ~ Stock and flow ~ Software simulation (NetLogo)</p>

                          <p>Skills</p>

                          <p>I have used object theory extensively in both software engineering and programming. This enables me to create clear and accurate models of real-world systems, resulting in highly organised and extensible implementations of databases and applications.</p>

                          <p><b>Engineering skills</b></p>

                          <p>I have a sound understanding of the development cycle. I possess strong diagramming skills which enable me to illustrate concepts and models clearly and succinctly. I can produce precise, formal specifications which aim to eliminate the need for debugging logical bugs from finished code, and prevent \'insert-update-delete\' anomalies in databases.</p>

                          <p>Starting with an initial statement of requirements, I can separate out static data requirements from behavioural application requirements. I can turn the static data requirements into a set of distinct entity types (objects), with attributes, relationships and constraints, resulting in a normalised relational database. I can turn the behavioural application requirements into sets of usecase or method pre- and post-conditions, with pseudocode walk-throughs which recursively identify further methods on the method call tree, and help to speed up implemenation by programmers or coders.</p>

                          <p><b>Programming skills</b></p>

                          <p>I am experienced in several programming languages including C++/Qt, PHP, SQL, Perl, Java, SmallTalk and JavaScript. I have worked mainly on Linux, but have also programmed on Windows.</p>

                          <p>Over the years I have gained a solid understanding of the principles of object-oriented programming. I can learn new languages very quickly because I possess an almost instinctive expectation of the facilities that any mature language should be capable of providing. So, for example, when writing code in an unfamiliar language, I can usually feel that certain functions should already exist, and thus avoid re-inventing the wheel.</p>

                          <p>I am comfortable with most of the necessary support applications - DBMSs, compilers, FTP, web servers (Apache), OS command lines, diagramming tools, etc..</p>

                          <p><b>Work</b></p>

                          <p>Mortime Business Software Ltd. (my own company in England).</p>

                          <p>Freelance projects ~ CowMate: project management tool written in .NET\'s Managed C++ ~ Mortime Business System ~ PiggyBook: small business bookkeeping tool written in C++/Qt ~ AdTracker: advertisement-tracking tool written in C++/Qt with MySQL database ~ Various papers including A Theory of Relation to Object Mapping: why relations should be mapped to objects and not the other way around</p>

                          <p>Charisma Signs & Graphics (my own company in Sydney, Australia)</p>

                          <p>At one stage I was managing fourteen signwriters ( five full time) split into several teams producing painted and computerised signs and graphics.</p>

                          <p>The Torch newspaper, Visy-board, David\'s Holdings, Australia</p>

                          <p>Newspaper composition, proof-reading, illustration, graphic design, airbrush (including photo retouching) finished art, typography, dark room.</p>

                          <p>MOD (Royal Navy)</p>

                          <p>Electronic warfare. Support measures: interception and analysis of radio transmissions. Counter measures: jamming of radio transmissions.</p>

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
