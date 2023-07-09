<?php

class ScatterPlotForm extends View
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

    public function ScatterPlotForm()
    {
		$html = '<form enctype="multipart/form-data" method="post" action="' . $this->Registrar->Get( 'Config' )->RootURL . '/analytics/surecom/controller.php">
				 <div>Filter:</div>';
		foreach( $this->Registrar->Get('Types') as $Type )
		{
			$html .= '<div><input type="checkbox" name="Filters[]" value="' . $Type . '" checked="checked" />' . $Type . '</div>';
		}
		$html .= '<p>Upload another file:</p>
				  <div><input type="file" name="CSVFile" /></div>
				  <div><input type="submit" name="SubmitQuery" value="Submit Query" /></div>
				  </form>';

		return $html;
    }
}

?>
