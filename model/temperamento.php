<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Temperamento
{
    private $id_temperamento;
    private $nome;
    private $descricao;

    public function getIdTemperamento()
    {
        return $this->id_temperamento;
    }

    public function setIdTemperamento($id_temperamento)
    {
        $this->id_temperamento = $id_temperamento;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function __construct()
    {
        $this->connect = new Connect();
    }

    public function list_all()
    {
        $sql = "SELECT * FROM temperamento";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $temperamentos = [];
        while ($temperamento = $result->fetch_assoc()) {
            $temperamentos[] = $temperamento;
        }
        return $temperamentos;
    }

    public function search_by_id($id_temperamento)
    {
        $sql = "SELECT * FROM temperamento WHERE id_temperamento = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_temperamento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}