<?php

class EmailViewInvoiceLink extends View
{
    public function __construct( $inRegistrar )
    {
        $Interfaces = array();
        $ExtraInterfaces = array();
        foreach( $ExtraInterfaces as $ExtraInterface )
        {
            array_push( $Interfaces, $ExtraInterface );
        }
        parent::__construct( $inRegistrar, $Interfaces );
    }

    public function GenerateView( $inRegistrar )
    {
        if( $inRegistrar->Get('EmailPaymentLink') )
        {
            $CustomerDetails = array();
            $CustomerDetails = $inRegistrar->Get('CustomerDetails');

            $EmailTo = $CustomerDetails['email_address'];
            $EmailFrom = "davidmortimer@topspek.com";
            $EmailSubject = "Invoice from topspek.com";

            $EmailMessage = '
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Topspek Web Applications - Middlesbrough, UK - Fast Websites - PHP and MySQL</title>
    </head>
    <body>
        <img src="' . $inRegistrar->Get('Config')->RootURL . '/media/images/TOPSPEK_LOGO_012.png" alt="Topspek Software Systems Logo" /><br />
        <p>Fast, secure, responsive websites created with PHP and MySQL</p><br /><br />

        Dear ' . $CustomerDetails['contact_name'] . '<br /><br />
        Please visit our website to view your invoice.<br /><br />

        <a href="' . $inRegistrar->Get('Config')->RootURL . '/financial_tools/accounting/invoicing/display_statement/controller.php?CustomerId=' . $CustomerDetails['customer_id'] . '&StatementYear=' . $inRegistrar->Get('StatementYear') . '&StatementMonth=' . $inRegistrar->Get('StatementMonth') . '">Click here</a><br /><br />

        Thank you.<br /><br />

        Kind regards,<br /><br />

        David Mortimer<br />
        Chief Software Engineer<br />
        Topspek Software Systems<br /><br />
        ----------------------------------<br />
        Website: <a href="' . $inRegistrar->Get('Config')->RootURL . '">Topspek</a><br />
        Email: davidmortimer@topspek.com<br />
        Phone: 01642 973 259<br />
    </body>
</html>';

            $Headers  = 'MIME-Version: 1.0' . "\r\n";
            $Headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $Headers .= 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
        }
    }
}


//$Headers  = 'MIME-Version: 1.0' . "\r\n";
//$Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
/*
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Topspek Web Applications - Middlesbrough, UK - Fast Websites - PHP and MySQL</title>
    </head>
    <body>
        <img src="' . $inRegistrar->Get('Config')->RootURL . '/media/images/TOPSPEK_LOGO_012.png" /><br />
        <p>Fast, secure, responsive websites created with PHP and MySQL</p><br /><br />

        Dear ' . $CustomerDetails['contact_name'] . '<br /><br />
        Please visit our website to view your invoice.<br /><br />

        <a href="' . $inRegistrar->Get('Config')->RootURL . '/financial_tools/accounting/invoicing/display_statement/controller.php?CustomerId=' . $CustomerDetails['customer_id'] . '&StatementYear=' . $inRegistrar->Get('StatementYear') . '&StatementMonth=' . $inRegistrar->Get('StatementMonth') . '">Click here</a><br /><br />

        Kind regards,<br /><br />

        David Mortimer<br />
        Chief Software Engineer<br />
        Topspek Software Systems<br /><br />
        ----------------------------------<br />
        Website: <a href="' . $inRegistrar->Get('Config')->RootURL . '">Topspek</a><br />
        Email: davidmortimer@topspek.com<br />
        Phone: 01642 973 259<br />
    </body>
</html>
*/


/*
<!DOCTYPE html>
<html lang="en"> 
    <head> 
        <title>Welcome to CodexWorld</title> 
    </head> 
    <body> 
        <h1>Thanks you for joining with us!</h1> 
        <table style="border: 1px; width: 100%;"> 
            <tr> 
                <th>Name:</th><td>CodexWorld</td> 
            </tr> 
            <tr style="background-color: #e0e0e0;"> 
                <th>Email:</th><td>contact@codexworld.com</td> 
            </tr> 
            <tr> 
                <th>Website:</th><td><a href="http://www.codexworld.com">www.codexworld.com</a></td> 
            </tr> 
        </table> 
    </body> 
</html>
*/














































?>
