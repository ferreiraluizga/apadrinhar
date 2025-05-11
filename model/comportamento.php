<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Comportamento
{
    private $id_comportamento;
    private $nome;
    private $descricao;

    public function getIdComportamento()
    {
        return $this->id_comportamento;
    }

    public function setIdComportamento($id_comportamento)
    {
        $this->id_comportamento = $id_comportamento;
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
        $sql = "SELECT * FROM comportamento";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $comportamentos = [];
        while ($comportamento = $result->fetch_assoc()) {
            $comportamentos[] = $comportamento;
        }
        return $comportamentos;
    }

    public function search_by_id($id_comportamento)
    {
        $sql = "SELECT * FROM comportamento WHERE id_comportamento = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_comportamento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}