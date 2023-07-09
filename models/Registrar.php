<?php

class Registrar
{
//====================================================================
    private $Handlers = array();
    private $DataStore = array();
//====================================================================
    // Registrar::Register

    public function Register( $ObjectRef, $MethodName )
    {
        array_push( $this->Handlers, $ObjectRef, $MethodName );
    }
//====================================================================
    // Registrar::Save

    public function Save( $Data, $DataKey )
    {
        $this->DataStore[$DataKey] = $Data;
    }
//====================================================================
    // Registrar::Get

    public function Get( $DataKey )
    {
        return $this->DataStore[$DataKey];
    }
//====================================================================
    // Registrar::Notify

    public function Notify()
    {
        for( $i = 0; $i < count( $this->Handlers ); $i = $i + 2 )
        {
            $ObjectRef = $this->Handlers[$i];
            $MethodName = $this->Handlers[$i+1];
            $ObjectRef->$MethodName( $this );
        }
    }
//====================================================================
}

?>
