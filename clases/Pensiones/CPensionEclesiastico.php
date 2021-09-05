<?php
/*
 * Clase CPension
 * Actualizada por : Daniel Letelier
 * Fecha actualización : 01/02/2013 
 * Hora actualización : 16:22 hrs
 */
class CPensionEclesiastico
{
    private $id_pension;
    private $id_am;
    
    private $id_tipo_pension;
    private $id_prevision;
    private $id_tipo_prevision;
    
    /*___________________ Nombre datos de pensión ____________________*/
    private $tipo_pension;
    private $prevision;
    private $tipo_prevision;
    /*________________________________________________________________*/
    
    private $monto;
    private $nro_ss;
    private $observacion;
    private $estado_pension;
    
    /*__________________________ Otros datos _________________________*/
    private $dias_restantes_compromiso;
    private $estado_compromiso;
    private $id_compromiso;
    private $extra;
    private $id_ipma;
    /*________________________________________________________________*/
    
    /*###################################### GETERS ###################################################*/
    public function GetIdPension()
    {
        return $this->id_pension;
    }
    
    public function GetIdAm()
    {
        return $this->id_am;
    }
    
    public function GetIdTipoPension()
    {
        return $this->id_tipo_pension;
    }
    
    public function GetIdPrevision()
    {
        return $this->id_prevision;
    }
    
    public function GetIdTipoPrevision()
    {
        return $this->id_tipo_prevision;
    }
    
    /*________________________ Nombre datos de pensión ______________________*/
    public function GetTipoPension()
    {
        return $this->tipo_pension;
    }
    
    public function GetPrevision()
    {
        return $this->prevision;
    }
    
    public function GetTipoPrevision()
    {
        return $this->tipo_prevision;
    }
    /*_______________________________________________________________________*/
    
    public function GetMonto()
    {
        return $this->monto;
    }
    
    public function GetNroSeguroSocial()
    {
        return $this->nro_ss;
    }
    
    public function GetObservacion()
    {
        return $this->observacion;
    }
    
    public function GetEstadoPension()
    {
        return $this->estado_pension;
    }
    
    /*______________________ Otros datos _____________________________*/
    public function GetDiasRestantesCompromiso()
    {
        return $this->dias_restantes_compromiso;
    }
    
    public function GetEstadoCompromiso()
    {
        return $this->estado_compromiso;
    }
    
    public function GetIdCompromiso()
    {
        return $this->id_compromiso;
    }
    
    public function GetExtra()
    {
        return $this->extra;
    }
    
    public function GetIdIpma()
    {
        return $this->id_ipma;
    }
    /*____________________________________________________________*/
    /*###########################################################################################################*/
    
    /*################################################# SETERS ##################################################*/    
    public function SetIdPension($id_pension)
    {
        return $this->id_pension = $id_pension;
    }
    
    public function SetIdAm($id_am)
    {
        return $this->id_am = $id_am;
    }
    
    public function SetIdTipoPension($id_tipo_pension)
    {
        return $this->id_tipo_pension = $id_tipo_pension;
    }
    
    public function SetIdPrevision($id_prevision)
    {
        return $this->id_prevision = $id_prevision;
    }
    
    public function SetIdTipoPrevision($id_tipo_prevision)
    {
        return $this->id_tipo_prevision = $id_tipo_prevision;
    }
    
    /*_________________________ Nombre datos de pensión _____________________*/
    public function SetTipoPension($tipo_pension)
    {
        return $this->tipo_pension = utf8_encode($tipo_pension);
    }
    
    public function SetPrevision($prevision)
    {
        return $this->prevision = utf8_encode($prevision);
    }
    
    public function SetTipoPrevision($tipo_prevision)
    {
        return $this->tipo_prevision = utf8_encode($tipo_prevision);
    }
    /*_______________________________________________________________________*/
    
    public function SetMonto($monto)
    {
        return $this->monto = $monto;
    }
    
    public function SetNroSeguroSocial($nro_ss)
    {
        return $this->nro_ss = $nro_ss;
    }
    
    public function SetObservacion($observacion)
    {
        return $this->observacion = $observacion;
    }
    
    public function SetEstadoPension( $estado_pension)
    {
        return $this->estado_pension = $estado_pension;
    }
    
    /*__________________________ Otros datos ____________________________*/    
    public function SetDiasRestantesCompromiso($dias_restantes_compromiso)
    {
        $this->dias_restantes_compromiso = $dias_restantes_compromiso;
    }
    
    public function SetEstadoCompromiso($estado_compromiso)
    {
        $this->estado_compromiso = $estado_compromiso;
    }
    
    public function SetExtra($extra)
    {
        $this->extra = $extra;
    }
    
    public function SetIdCompromiso($id_compromiso)
    {
        $this->id_compromiso = $id_compromiso;
    }
    
    public function SetIdIpma($id_ipma)
    {
        $this->id_ipma = $id_ipma;
    }
    /*____________________________________________________________________*/
    /*###############################################################################################################*/    
}
?>