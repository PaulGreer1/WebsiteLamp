<?php
//======================================================================
include "Config.php";
//======================================================================
// VIEWS

include $Registrar->Get('Config')->InterfacesDir . '/View.php';

include $Registrar->Get('Config')->InterfacesDir . '/PageView.php';
$Title = 'Topspek\'s Web Applications - Middlesbrough, UK - Powerful dynamic websites - PHP and MySQL';
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
