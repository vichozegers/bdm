<?php
class CData
{
    private $desde;
    private $select;
    private $from;
    private $where;
    private $resultado;

    function CData()
    {
        $this->desde=array();
    }
    //Seters
    public function SetDesde($d)
    {
        $this->desde[0]=$d;
    }
    public function addDesde($d)
    {
        $this->desde[count($this->desde)]=$d;
    }
    public function SetSelect($s)
    {
        $this->select=$s;
    }
    public function addSelect($s)
    {
        $this->select.=$s;
    }
     public function SetFrom($s)
    {
        $this->from=$s;
    }
    public function addFrom($s)
    {
        $this->from.=$s;
    }
     public function SetWhere($s)
    {
        $this->where=$s;
    }
    public function addWhere($s)
    {
        $this->where.=$s;
    }
    public function SetResultado($resultado)
    {
        $this->resultado=$resultado;
    }
    //Geters
    public function GetQuery()
    {
        return $this->select." ".$this->from." ".$this->where;
    }
    public function GetResultado()
    {
        return $this->resultado;
    }
    public function GetDesde()
    {
        return $this->desde;
    }
    //Clone
    
}
?>