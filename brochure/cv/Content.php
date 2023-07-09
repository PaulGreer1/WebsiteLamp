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

        <p><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/ME_002.png" style="width: 128px; height: 128px;" alt="" /></p>

        <h2>For the last twenty-one years, I\'ve worked in various areas of software development; mainly in engineering and programming. Before this, I spent about 18 years as a commercial artist (finished art, signwriter, artist/illustrator (airbrush)).</h2>

        <p>I have also worked in many other areas of software development. I\'ve enjoyed many years in both the database and application domains. Fresh challenges and opportunities to learn new skills are always most welcome. I have many goals and a determined nature. I like to theorise as I work, and am always on the lookout for principles and rules which may apply to different kinds of task. I find that this improves overall efficiency because concepts and techniques invented or discovered during one particular task can often be extrapolated to other task types.</p>

        <h2>Education</h2>

        <!--<p><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/education.jpg" alt="" /></p>-->

        <p>BSc degree consisting of computer science, mathematics and systems analysis modules. The Open University, 2004 - 2011. First Class.</p>

        <p>Over seven years, I combined my degree studies with my work. I found that the two activities naturally complemented each other - my work determining the modules that I needed to study, and the course modules often suggesting the type of work that I would be most interested in. The following is a selection of some of the subjects I studied.</p>

                  <table id="t1">
                  <tr>
                      <th colspan="2">Computer Science</th>
                  </tr>
                  <tr>
                      <td>Relational databases: theory and practice</td>
                      <td>Data requirements analysis ~ Relational theory ~ Entity relationship modelling ~ Logical schema creation ~ Referential integrity ~ Normal forms ~ Database design and implementation ~ SQL ~ Constraints</td>
                  </tr>
                  <tr>
                      <td>Modelling computer processes</td>
                      <td>Finite automata ~ Automata with memory ~ Language and grammar creation ~ Reasoned programming ~ Object interaction ~ Concepts of concurrency ~ Programming concurrency ~ Threads</td>
                  </tr>
                  <tr>
                      <td>Computing: an object oriented approach</td>
                      <td>Classes and objects ~ Inheritance ~ Modelling, designing and implementing software systems ~ Structural models ~ Invariants ~ Computing and networks</td>
                  </tr>
                  <tr>
                      <td>Building blocks of software</td>
                      <td>Data types ~ Sets ~ Binary trees ~ Formal logic ~ Pre-, mid- and post-conditions ~ Rules of inference ~ Recursion ~ Algorithm efficiency ~ Mathematical induction ~ Recurrence systems</td>
                  </tr>
                  </table><br />

                  <table  id="t2">
                  <tr>
                      <th colspan="2">Mathematics</th>
                  </tr>
                  <tr>
                      <td>Pure mathematics</td>
                      <td>Sequences ~ Conics ~ Matrix transformations ~ Calculus ~ Taylor polynomials ~ Complex numbers ~ Number theory ~ Groups ~ Proof and reasoning</td>
                  </tr>
                  <tr>
                      <td>Mathematical modelling</td>
                      <td>Functions ~ Modelling with sequences, matrices and vectors ~ Differential equations ~ Growth and decay ~ Chance ~ Variation ~ Estimating</td>
                  </tr>
                  </table><br />

                  <table  id="t3">
                  <tr>
                      <th colspan="2">Systems analysis</th>
                  </tr>
                  <tr>
                      <td>Understanding system complexity</td>
                      <td>Mess analysis ~ Cause and effect ~ Positive feedback loops ~ Dynamic equilibrium ~ Chaos ~ Lag ~ Control loops ~ System dynamics ~ Stock and flow ~ Software simulation (NetLogo)</td>
                  </tr>
                  </table>


        <h2>Skills</h2>

        <!--<p><img src="' . $this->Registrar->Get('Config')->RootURL . '/media/images/SKILLS_002.jpg" alt="" /></p>-->

        <p>I have used object theory extensively within database design, software engineering and programming. This enables me to create clear and accurate models of real-world systems, resulting in highly organised and extensible implementations of databases and applications.</p>

        <h3>Engineering skills</h3>

        <p>I have a sound understanding of the development cycle. I possess strong diagramming skills which enable me to illustrate concepts and models clearly and succinctly. I can produce precise, formal specifications which aim to eliminate the need for debugging logical bugs from finished code, and prevent \'insert-update-delete\' anomalies in databases.</p>

        <p>Starting with an initial statement of requirements, I can separate out static data requirements from behavioural application requirements. I can turn the static data requirements into a set of distinct entity types (objects), with attributes, relationships and constraints, resulting in a normalised relational database. I can turn the behavioural application requirements into sets of usecase or method pre- and post-conditions, with pseudocode walk-throughs which recursively identify further methods on the method call tree, and help to speed up implemenation by programmers or coders.</p>

        <h3>Programming skills</h3>

        <p>I am experienced in several programming languages including Java, Python, C++/Qt, PHP, SQL, Perl, SmallTalk and JavaScript. I have worked mainly on Linux, but have also programmed on Windows.</p>

        <p>Over the years I have gained a solid understanding of the principles of object-oriented programming. I can learn new languages very quickly because I possess an almost instinctive expectation of the facilities that any mature language should be capable of providing. So, for example, when writing code in an unfamiliar language, I can usually feel that certain functions should already exist, and thus avoid re-inventing the wheel.</p>

        <p>I am comfortable with most of the necessary support applications - DBMSs, compilers, FTP, web servers (Apache), OS command lines, diagramming tools, etc..</p>

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
