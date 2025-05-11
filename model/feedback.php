<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Feedback
{
    private $id_feedback;
    private $discipulado;
    private $padrinho;
    private $descricao;
    private $avaliacao;

    public function getIdFeedback()
    {
        return $this->id_feedback;
    }

    public function setIdFeedback($id_feedback)
    {
        $this->id_feedback = $id_feedback;
    }

    public function getDiscipulado()
    {
        return $this->discipulado;
    }

    public function setDiscipulado(Discipulado $discipulado)
    {
        $this->discipulado = $discipulado;
    }

    public function getPadrinho()
    {
        return $this->padrinho;
    }

    public function setPadrinho(Padrinho $padrinho)
    {
        $this->padrinho = $padrinho;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getAvaliacao()
    {
        return $this->avaliacao;
    }

    public function setAvaliacao($avaliacao)
    {
        $this->avaliacao = $avaliacao;
    }

    public function __construct()
    {
        $this->connect = new Connect();
    }

    public function insert()
    {
        $sql = "INSERT INTO feedback (id_discipulado, id_padrinho, descricao, avaliacao) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('iiss', $this->discipulado->getIdDiscipulado(), $this->padrinho->getIdPadrinho(), $this->descricao, $this->avaliacao);
        return $stmt->execute();
    }

    public function list_all_by_id($id_discipulado)
    {
        $sql = "SELECT * FROM feedback 
                INNER JOIN padrinho ON feedback.id_padrinho = padrinho.id_padrinho 
                WHERE id_discipulado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_discipulado);
        $stmt->execute();
        $result = $stmt->get_result();
        $feedbacks = [];
        while ($feedback = $result->fetch_assoc()) {
            $feedbacks[] = $feedback;
        }
        return $feedbacks;
    }

    public function delete($id_feedback)
    {
        $sql = "DELETE FROM feedback WHERE id_feedback = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_feedback);
        return $stmt->execute();
    }
}