<?php

class Connect {

    private $host = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $banco = "juventude";
    private $connect;

    public function __construct() {
        $this->connect = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);
        $this->connect->set_charset("utf8");
        if ($this->connect->connect_error) {
            die("Falha na Conexão: " . $this->connect->connect_error);
        }
    }

    public function getConnect(){
        return $this->connect;
    }
}

?>