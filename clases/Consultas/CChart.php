<?php

class CChart {
    private $data;
    private $nombres;
    private $title;
    private $colores;

    public function CChart($data, $nombre) {
        $this->data=$data;
        $this->nombres=$nombre;
        $this->title="BDU Consultas";
        $this->colores=self::random_color();
    }
    // add methods
    public function addData($data) {
        $this->data.=",".$data;
    }
    public function addNombres($nombre) {
        $this->nombres.="|".$nombre;
        $this->colores.=",".self::random_color();
    }
  /*  private function addColores($color)
    {
        $this->data.=$color;
    } */

    //GETTERS
    public function GetData() {
        return $this->data;
    }
    public function GetNombres() {
        return $this->nombres;
    }
    public function GetTitulo() {
        return $this->title;
    }
    public function GetColores() {
        return $this->colores;
    }

    private static function random_color() {
        mt_srand((double)microtime()*1000000);
        $color = '';
        while(strlen($color)<6) {
            $color .= sprintf("%02X", mt_rand(0, 255));
        }
        return $color;
    }

}
?>