<?php
class CDescuento
{
    private $tipo;
    private $monto;
    private $id;

    public function CDescuento()
    {
        $this->tipo=0;
        $this->monto=0;
        $this->id=0;
    }

/***********************************************************
 *                                                         *
 *                                                         *
 *                                                         *
 ***********************************************************/

    public function GetTipo()
    {
        return $this->tipo;
    }

    public function GetMonto()
    {
        return $this->monto;
    }

    public function GetId()
    {
        return $this->id;
    }
/*******************************************************************
 *                                                                 *
 *                                                                 *
 *                                                                 *
 *******************************************************************/

    public function SetTipo($tipo)
    {
        $this->tipo=$tipo;
    }

    public function SetMonto($monto)
    {
        $this->monto=$monto;
    }
    public function SetId($id)
    {
        $this->id=$id;
    }
}
?>