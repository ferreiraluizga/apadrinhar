<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Linguagem
{
    private $id_linguagem;
    private $nome;
    private $descricao;

    public function getIdLinguagem()
    {
        return $this->id_linguagem;
    }

    public function setIdLinguagem($id_linguagem)
    {
        $this->id_linguagem = $id_linguagem;
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
        $sql = "SELECT * FROM linguagem_amor";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $linguagens = [];
        while ($linguagem = $result->fetch_assoc()) {
            $linguagens[] = $linguagem;
        }
        return $linguagens;
    }

    public function search_by_id($id_linguagem)
    {
        $sql = "SELECT * FROM linguagem_amor WHERE id_linguagem = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_linguagem);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}