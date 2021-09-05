<?php

class CFiltros {
    private $principal;
    private $aux;

    public function CFiltros()
    {

    }

    public function SetPrincipal($p)
    {
        $this->principal=$p;
    }
    public function SetAux($a)
    {
        $this->aux=$a;
    }
    public function GetPrincipal()
    {
        return $this->principal;
    }
    public function GetAux()
    {
        return $this->aux;
    }
}
?>