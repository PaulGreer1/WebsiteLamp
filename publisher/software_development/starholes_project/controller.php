<?php
//======================================================================
include "Config.php";
//======================================================================
// VIEWS

include $Registrar->Get('Config')->InterfacesDir . '/View.php';

include $Registrar->Get('Config')->InterfacesDir . '/PageView.php';
//$Title = 'TopSpek Software Systems | Automating Business Processes | OOP | Agile Software Development';
$Title = 'Starholes video game for phones, tablets, laptops, PCs | Family game';
$PageView = new PageView( $Registrar, $Title );
$Registrar->Register( $PageView, 'GenerateView' );
//======================================================================
include $Registrar->Get('Config')->ModelsDir . '/AdBanner.php';
$AdBanner = new AdBanner( $Registrar );
$Registrar->Save( $AdBanner->AdBanner(), 'AdBanner' );
//======================================================================
$Registrar->Notify();
//======================================================================
?>
