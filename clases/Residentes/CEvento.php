<?php

class CEvento
{
    private $id;
    private $origen;
    private $destino;
    private $fecha;
    private $fecha_real;
    private $obs;
    private $responsable;
    private $descripcion;
    private $aux;
    private $id_adulto;
    private $tipo;
    ////////gets///////////////////
    public function GetId()
    {
        return $this->id;
    }
    public function GetLugarOrigen()
    {
        return $this->origen;
    }
    public function GetLugarDestino()
    {
        return $this->destino;
    }
    public function GetFecha()
    {
        return $this->fecha;
    }
    public function GetFechaReal()
    {
        return $this->fecha_real;
    }
    public function GetObservaciones()
    {
        return $this->obs;
    }
    public function GetResponsable()
    {
        return $this->responsable;
    }
    public function GetDescripcion()
    {
        return $this->descripcion;
    }
    public function GetIdAdulto()
    {
        return $this->id_adulto;
    }
    public function GetAux()
    {
        return $this->aux;
    }
    public function GetTipo()
    {
        return $this->tipo;
    }

    ////////sets///////////////////
    public function SetId($id)
    {
        $this->id=$id;
    }
    public function SetLugarOrigen($origen)
    {
        $this->origen=$origen;
    }
    public function SetLugarDestino($destino)
    {
        $this->destino=$destino;
    }
    public function SetFecha($fecha)
    {
        $this->fecha=$fecha;
    }
    public function SetFechaReal($fecha_real)
    {
        $this->fecha_real=$fecha_real;
    }
    public function SetObservaciones($obs)
    {
        $this->obs=$obs;
    }
    public function SetResponsable($responsable)
    {
        $this->responsable=$responsable;
    }
    public function SetDescripcion($descripcion)
    {
        $this->descripcion=$descripcion;
    }
    public function SetIdAdulto($idad)
    {
        $this->id_adulto=$idad;
    }
    public function SetAux($aux)
    {
       $this->aux=$aux;
    }
    public function SetTipo($tipo)
    {
         $this->tipo=$tipo;
    }
}
?>