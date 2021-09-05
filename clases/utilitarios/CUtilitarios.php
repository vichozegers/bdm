<?php

//**General - "Fundacion las Rosas"*************//
//**********************************************//

class CUtilitarios
{
    private $m_CampoNumId;
    private $m_CampoNum1;
    private $m_CampoNum2;
    private $m_CampoNum3;
    private $m_CampoNum4;
    private $m_CampoNum5;
    private $m_CampoNum6;

    private $m_CampoVar1;
    private $m_CampoVar2;
    private $m_CampoVar3;
    private $m_CampoVar4;
    private $m_CampoVar5;
    private $m_CampoVar6;
    private $m_CampoVar7;
    private $m_CampoVar8;
    private $m_CampoVar9;
    private $m_CampoVar10;
    private $m_CampoVar11;
    private $m_CampoVar12;
    private $m_CampoVar13;
    private $m_CampoVar14;
    private $m_CampoVar15;
    private $m_CampoVar16;
    private $m_CampoVar17;

    //********************************
    //  Constructor
    //*******************************

    public function __construct()
    {
        $this->m_CampoNumId=0;
    }


    public function GetCamponumid()
    {
        if(isset($this->m_CampoNumId))
        return $this->m_CampoNumId;
        else
        return 'null';
    }

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

    public function GetCamponum5()
    {
        return $this->m_CampoNum5;
    }

    public function GetCamponum6()
    {
        return $this->m_CampoNum6;
    }

//letras
    
    public function GetCampovar1()
    {
        return $this->m_CampoVar1;
    }
    
    public function GetCampovar2()
    {
        return $this->m_CampoVar2;
    }
    
    public function GetCampovar3()
    {
        return $this->m_CampoVar3;
    }

    public function GetCampovar4()
    {
        return $this->m_CampoVar4;
    }

    public function GetCampovar5()
    {
        return $this->m_CampoVar5;
    }
    
    public function GetCampovar6()
    {
        return $this->m_CampoVar6;
    }

    public function GetCampovar7()
    {
        return $this->m_CampoVar7;
    }

    public function GetCampovar8()
    {
        return $this->m_CampoVar8;
    }
    
    public function GetCampovar9()
    {
        return $this->m_CampoVar9;
    }

    public function GetCampovar10()
    {
        return $this->m_CampoVar10;
    }

    public function GetCampovar11()
    {
        return $this->m_CampoVar11;
    }

    public function GetCampovar12()
    {
        return $this->m_CampoVar12;
    }

    public function GetCampovar13()
    {
        return $this->m_CampoVar13;
    }

    public function GetCampovar14()
    {
        return $this->m_CampoVar14;
    }

    public function GetCampovar15()
    {
        return $this->m_CampoVar15;
    }

    public function GetCampovar16()
    {
        return $this->m_CampoVar16;
    }

    public function GetCampovar17()
    {
        return $this->m_CampoVar17;
    }

    
    
//*******************************************************************
    
    public function SetCamponumid($camponumid)
    {
        $this->m_CampoNumId=$camponumid;
    }

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

    public function SetCamponum5($camponum5)
    {
        $this->m_CampoNum5=$camponum5;
    }

    public function SetCamponum6($camponum6)
    {
        $this->m_CampoNum6=$camponum6;
    }



    public function SetCampovar1($campovar1)
    {
        $this->m_CampoVar1=$campovar1;
    }

    public function SetCampovar2($campovar2)
    {
        $this->m_CampoVar2=$campovar2;
    }

    public function SetCampovar3($campovar3)
    {
        $this->m_CampoVar3=$campovar3;
    }

    public function SetCampovar4($campovar4)
    {
        $this->m_CampoVar4=$campovar4;
    }

    public function SetCampovar5($campovar5)
    {
        $this->m_CampoVar5=$campovar5;
    }

    public function SetCampovar6($campovar6)
    {
        $this->m_CampoVar6=$campovar6;
    }
    
    public function SetCampovar7($campovar7)
    {
        $this->m_CampoVar7=$campovar7;
    }
    
    public function SetCampovar8($campovar8)
    {
        $this->m_CampoVar8=$campovar8;
    }
    
    public function SetCampovar9($campovar9)
    {
        $this->m_CampoVar9=$campovar9;
    }
    
    public function SetCampovar10($campovar10)
    {
        $this->m_CampoVar10=$campovar10;
    }
    
    public function SetCampovar11($campovar11)
    {
        $this->m_CampoVar11=$campovar11;
    }
    
    public function SetCampovar12($campovar12)
    {
        $this->m_CampoVar12=$campovar12;
    }
    
    public function SetCampovar13($campovar13)
    {
        $this->m_CampoVar13=$campovar13;
    }
    
    public function SetCampovar14($campovar14)
    {
        $this->m_CampoVar14=$campovar14;
    }
    
    public function SetCampovar15($campovar15)
    {
        $this->m_CampoVar15=$campovar15;
    }
    
    public function SetCampovar16($campovar16)
    {
        $this->m_CampoVar16=$campovar16;
    }
    
    public function SetCampovar17($campovar17)
    {
        $this->m_CampoVar17=$campovar17;
    }
    
}
?>
