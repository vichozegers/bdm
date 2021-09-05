<?php

class CPersonaIngFisico
{
    private $m_Id;
    private $m_Nombre;
    private $m_ApellidoPaterno;
    private $m_ApellidoMaterno;
    private $m_Rut;
    private $m_Domicilio;
    private $m_Comuna;
    private $m_Region;
    private $m_Hogar;
    private $m_Categoria;
    private $m_FechaDeseso;
    private $tipo;
    private $aux;
    private $m_HogarNombre;
    private $m_HogarDireccion;
    private $m_fecha_ingreso_fisico;
    private $m_id_apoderado;
    
    //********************************
    //  Constructor
    //*******************************

    public function __construct()
    {
        $this->m_Id=0;
    }

    //*****************************************************************
    // geters
    //*****************************************************************

    public function GetId()
    {
        if(isset($this->m_Id))
        return $this->m_Id;
        else
        return 'null';
    }
    public function GetRut2()
    {
        return substr($this->m_Rut, -1);
    }
    public function GetRut1()
    {
        return substr($this->m_Rut, 0, -1);
    }
    public function GetRut()
    {
        return $this->m_Rut;
    }
    public function GetNombre()
    {
        return $this->m_Nombre;
    }
    public function GetApellidoPaterno()
    {
        return $this->m_ApellidoPaterno;
    }
    public function GetApellidoMaterno()
    {
        return $this->m_ApellidoMaterno;
    }
    public function GetDomicilio()
    {
        return $this->m_Domicilio;
    }
    public function GetComuna()
    {
        if(isset($this->m_Comuna))
        return $this->m_Comuna;
        else
        return 'null';
    }
    public function GetRegion()
    {
        if(isset($this->m_Region))
        return $this->m_Region;
        else
        return 'null';
    }
    public function GetHogar()
    {
        return $this->m_Hogar;
    }
    public function GetCategoria()
    {
        return $this->m_Categoria;
    }
    
    public function GetFechaDeseso()
    {
        return $this->m_FechaDeseso;
    }
    
    public function GetTipo()
    {
        return $this->tipo;
    }

    public function GetAux()
    {
        return $this->aux;
    }
    
    public function GetHogarNombre()
    {
        return $this->m_HogarNombre;
    }
    
    public function GetHogarDireccion()
    {
        return $this->m_HogarDireccion;
    }
    
    public function GetFechaIngresoFisico()
    {
        return $this->m_fecha_ingreso_fisico;    
    }
    
    public function GetIdApoderado()
    {   
        if(isset($this->m_id_apoderado))
            return $this->m_id_apoderado;
        else
            return '';
    }
    
    //*******************************************
    //Seters
    //*******************************************

    public function SetId($id)
    {
        $this->m_Id=$id;
    }
    public function SetRut($rut)
    {
        $this->m_Rut=$rut;
    }
    public function SetNombre($nombre)
    {
        $this->m_Nombre=$nombre;
    }
    public function SetApellidoPaterno($ap)
    {
        $this->m_ApellidoPaterno=$ap;
    }
    public function SetApellidoMaterno($am)
    {
        $this->m_ApellidoMaterno=$am;
    }
    public function SetDomicilio($domicilio)
    {
        $this->m_Domicilio=$domicilio;
    }
    public function SetComuna($comuna)
    {
        $this->m_Comuna=$comuna;
    }
    public function SetRegion($region)
    {
        $this->m_Region=$region;
    }
    public function SetHogar($hogar)
    {
        $this->m_Hogar=$hogar;
    }
    public function SetCategoria($categoria)
    {
        $this->m_Categoria=$categoria;
    }
    public function SetFechaDeseso($deseso)
    {
        $this->m_FechaDeseso=$deseso;
    }
    public function SetTipo($t)
    {
        $this->tipo=$t;
    }
    public function SetAux($aux)
    {
        $this->aux=$aux;
    }
    public function SetHogarNombre($hogar_nombre)
    {
        $this->m_HogarNombre=$hogar_nombre;
    }
    public function SetHogarDireccion($hogar_direccion)
    {
        $this->m_HogarDireccion=$hogar_direccion;
    }
    public function SetFechaIngresoFisico($fecha_ingreso_fisico)
    {
        $this->m_fecha_ingreso_fisico=$fecha_ingreso_fisico;
    }
    public function SetIdApoderado($id_apoderado)
    {
        $this->m_id_apoderado=$id_apoderado;
    }
}
?>