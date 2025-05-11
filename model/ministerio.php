<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Ministerio
{
    private $id_ministerio;
    private $nome_ministerio;
    private $descricao_ministerio;
    private $nome_lider;
    private $telefone_lider;

    public function getIdMinisterio()
    {
        return $this->id_ministerio;
    }

    public function setIdMinisterio($id_ministerio)
    {
        $this->id_ministerio = $id_ministerio;
    }

    public function getNomeMinisterio()
    {
        return $this->nome_ministerio;
    }

    public function setNomeMinisterio($nome_ministerio)
    {
        $this->nome_ministerio = $nome_ministerio;
    }

    public function getDescricaoMinisterio()
    {
        return $this->descricao_ministerio;
    }

    public function setDescricaoMinisterio($descricao_ministerio)
    {
        $this->descricao_ministerio = $descricao_ministerio;
    }

    public function getNomeLider()
    {
        return $this->nome_lider;
    }

    public function setNomeLider($nome_lider)
    {
        $this->nome_lider = $nome_lider;
    }

    public function getTelefoneLider()
    {
        return $this->telefone_lider;
    }

    public function setTelefoneLider($telefone_lider)
    {
        $this->telefone_lider = $telefone_lider;
    }

    public function __construct()
    {
        $this->connect = new Connect();
    }

    public function list_all()
    {
        $sql = "SELECT * FROM ministerio";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $ministerios = [];
        while ($ministerio = $result->fetch_assoc()) {
            $ministerios[] = $ministerio;
        }
        return $ministerios;
    }

    public function search_by_id($id_ministerio)
    {
        $sql = "SELECT * FROM ministerio WHERE id_ministerio = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_ministerio);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}