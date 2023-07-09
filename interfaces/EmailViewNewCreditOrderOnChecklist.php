<?php
//######################################################################
class EmailViewNewCreditOrderOnChecklist extends View
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

    public function GenerateView( $inRegistrar )
    {
        $EmailSubject = 'New statements due for payment checks';

        $EmailMessage = "New credit statements have been added to the checklist that require immediate checking for payment.\r\n\r\n
                         Please login to http://www.topspek.com/ for the details.\r\n\r\n";

        foreach( $this->Registrar->Get('CompaniesAndStaffMembers') as $StaffMembers )
        {
            $EmailFrom = 'davidmortimer@topspek.com';
            foreach( $StaffMembers as $StaffMember )
            {
                $EmailTo .= $StaffMember['email_address'] . ", ";
            }

            $Unwanted = array( "content-type", "bcc:", "to:", "cc:", "href" );
            $Headers = 'From: ' . $EmailFrom . "\r\n" . 'Reply-To: ' . $EmailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail( $EmailTo, $EmailSubject, $EmailMessage, $Headers );
        }
	}
}
//######################################################################
?>
