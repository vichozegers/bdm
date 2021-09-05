<?php
class CUtilitariosIndicador
{
    private $m_CampoNum1;
    private $m_CampoNum2;
    private $m_CampoNum3;
    private $m_CampoNum4;

    
    //********************************
    //  Constructor
    //*******************************
    
    
//numerico

    public function GetCamponum1()
    {
        return $this->m_CampoNum1;
    }

    public function GetCamponum2()
    {
        return $this->m_CampoNum2;
    }

    public function GetCamponum3()
    {
        return $this->m_CampoNum3;
    }
    
    public function GetCamponum4()
    {
        return $this->m_CampoNum4;
    }
//*******************************************************************
    
    public function SetCamponum1($camponum1)
    {
        $this->m_CampoNum1=$camponum1;
    }

    public function SetCamponum2($camponum2)
    {
        $this->m_CampoNum2=$camponum2;
    }

    public function SetCamponum3($camponum3)
    {
        $this->m_CampoNum3=$camponum3;
    }

    public function SetCamponum4($camponum4)
    {
        $this->m_CampoNum4=$camponum4;
    }
}

?>
