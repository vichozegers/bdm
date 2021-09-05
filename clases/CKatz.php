<?php

class CKatz
{
    //Conexiones
    private $id;              // ID KATZ
    private $idam;            // ID AM
    private $idcontrol;       // ID Tipo de control
    private $idficha;         // ID Tipo de ficha de ingreso

    private $hogar;           // Hogar de procedencia de AM
    private $idhogar;
    //Katz
    private $katz_alimentacion;
    private $katz_continencia;
    private $katz_movilidad;
    private $katz_wc;
    private $katz_vestido;
    private $katz_lavado;
    private $resultado;
    private $funcionalidad;

    private $fecha_real;
    private $t_katz;
    private $obs;
    private $responsable;
    private $aux;

    public function __construct()
    {
        $this->katz_alimentacion=0;
        $this->katz_continencia=0;
        $this->katz_lavado=0;
        $this->katz_wc=0;
        $this->katz_vestido=0;
        $this->katz_movilidad=0;
        //$this->t_katz=1;
     }

    //
    // <- Get -> Conexiones
    //

    public function GetId()
    {
        if(isset($this->id))
          return $this->id;
        else
          return 'null';
    }

    public function GetIdAM()
    {
        if(isset($this->idam))
          return $this->idam;
        else
          return NULL;
    }

    public function GetIdControl()
    {
        if(isset($this->idcontrol))
          return $this->idcontrol;
        else
          return 'NULL';
    }

    public function GetIdFichaIngreso()
    {
        if(isset($this->idficha))
          return $this->idficha;
        else
          return 'NULL';
    }

    public function GetHogar()
    {
        return $this->hogar;
    }
    public function GetIdHogar()
    {
        return $this->idhogar;
    }
    public function GetKatzAlimentacion()
    {
        return $this->katz_alimentacion;
    }

    public function GetKatzContinencia()
    {
        return $this->katz_continencia;
    }

    public function GetKatzMovilidad()
    {
        return $this->katz_movilidad;
    }

    public function GetKatzWc()
    {
        return $this->katz_wc;
    }

    public function GetKatzVestido()
    {
        return $this->katz_vestido;
    }

    public function GetKatzLavado()
    {
        return $this->katz_lavado;
    }

    public function GetResultado()
    {
        return $this->resultado;
    }

    public function GetFuncionalidad()
    {
        return $this->funcionalidad;
    }

    public function GetFechaReal()
    {
        return $this->fecha_real;
    }

    public function GetTieneKatz()
    {
        return $this->t_katz;
    }

    public function GetObservacion()
    {
        return $this->obs;
    }

    public function GetResponsable()
    {
        return $this->responsable;
    }

    public function GetAux()
    {
        return $this->aux;
    }
    /******************************************************************************/

    //
    // <- Set ->  Conexiones
    //

    public function SetAux($a)
    {
        $this->aux=$a;
    }

    public function SetId($id)
    {
        $this->id=$id;
    }

    public function SetIdAM($idam)
    {
        $this->idam=$idam;
    }

    public function SetIdControl($idcontrol)
    {
        $this->idcontrol=$idcontrol;
    }

    public function SetIdFicha($idficha)
    {
        $this->idficha=$idficha;
    }

    //
    // <- Set -> Hogar
    //

    public function SetHogar($hogar)
    {
        $this->hogar=$hogar;
    }
    public function SetIdHogar($idhogar)
    {
        $this->idhogar=$idhogar;
    }
    //
    // <- Set -> Katz
    //

    public function SetKatzAlimentacion($ka)
    {
        if(isset($ka))
        $this->katz_alimentacion=$ka;
    }

    public function SetKatzContinencia($kc)
    {
        if(isset($kc))
        $this->katz_continencia=$kc;
    }

    public function SetKatzMovilidad($km)
    {
        if(isset($km))
        $this->katz_movilidad=$km;
    }

    public function SetKatzWc($kw)
    {
        if(isset($kw))
        $this->katz_wc=$kw;
    }

    public function SetKatzVestido($kv)
    {
        if(isset($kv))
        $this->katz_vestido=$kv;
    }

    public function SetKatzLavado($kl)
    {
        if(isset($kl))
        $this->katz_lavado=$kl;
    }

    public function SetResultado($resultado)
    {
        if(isset($resultado))
        $this->resultado=$resultado;
    }

    public function SetFuncionalidad($funcionalidad)
    {
        if(isset($funcionalidad))
        $this->funcionalidad=$funcionalidad;
    }

    public function SetFechaReal($fecha_real)
    {
        $this->fecha_real=$fecha_real;
    }

    public function SetTieneKatz($t_katz)
    {
        $this->t_katz=$t_katz;
    }

    public function SetObservacion($obs)
    {
        $this->obs=$obs;
    }

    public function SetResponsable($responsable)
    {
        $this->responsable=$responsable;
    }
    
}
?>