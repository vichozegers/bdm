<?php
class CPension
{
    private $id;
    private $prevision;
    private $tipo;
    private $monto;
    private $nro_ss;

/*******************************************************
 *                                                     *
 *                                                     *
 *                                                     *
 *******************************************************/

    public function GetTipo()
    {
        return $this->tipo;
    }

    public function GetPrevision()
    {
        return $this->prevision;
    }

    public function GetMonto()
    {
        return $this->monto;
    }

    public function GetNumeroSeguroSocial()
    {
        return $this->nro_ss;
    }
    public function GetId()
    {
        return $this->id;
    }

/***********************************************************
 *                                                         *
 *                                                         *
 *                                                         *
 ***********************************************************/

    public function SetTipo($tipo)
    {
        $this->tipo=$tipo;
    }

    public function SetPrevision($prevision)
    {
        $this->prevision=$prevision;
    }

    public function SetMonto($monto)
    {
        $this->monto=$monto;
    }

    public function SetNumeroSeguroSocial($nro_ss)
    {
        $this->nro_ss=$nro_ss;
    }

    public function SetId($id)
    {
        $this->id=$id;
    }

}
?>