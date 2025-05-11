<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Mensagem
{
    private $id_mensagem;
    private $padrinho_emissor;
    private $padrinho_receptor;
    private $apadrinhado;
    private $mensagem;
    private $data_mensagem;

    public function getIdMensagem()
    {
        return $this->id_mensagem;
    }

    public function setIdMensagem($id_mensagem)
    {
        $this->id_mensagem = $id_mensagem;
    }

    public function getPadrinhoEmissor()
    {
        return $this->padrinho_emissor;
    }

    public function setPadrinhoEmissor(Padrinho $padrinho_emissor)
    {
        $this->padrinho_emissor = $padrinho_emissor;
    }

    public function getPadrinhoReceptor()
    {
        return $this->padrinho_receptor;
    }

    public function setPadrinhoReceptor(Padrinho $padrinho_receptor)
    {
        $this->padrinho_receptor = $padrinho_receptor;
    }

    public function getApadrinhado()
    {
        return $this->apadrinhado;
    }

    public function setApadrinhado(Apadrinhado $apadrinhado)
    {
        $this->apadrinhado = $apadrinhado;
    }

    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    public function getDataMensagem()
    {
        return $this->data_mensagem;
    }

    public function setDataMensagem($data_mensagem)
    {
        $this->data_mensagem = $data_mensagem;
    }

    public function __construct()
    {
        $this->connect = new Connect();
    }

    public function insert()
    {
        $sql = "INSERT INTO mensagem (id_emissor, id_receptor, id_apadrinhado, mensagem) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('iiis', $this->getPadrinhoEmissor()->getIdPadrinho(), $this->getPadrinhoReceptor()->getIdPadrinho(), $this->getApadrinhado()->getIdApadrinhado(), $this->getMensagem());
        return $stmt->execute();
    }

    public function list_all_sended_by_id($id_padrinho)
    {
        $sql = "SELECT * FROM mensagem 
                INNER JOIN padrinho ON mensagem.id_receptor = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON mensagem.id_apadrinhado = apadrinhado.id_apadrinhado 
                WHERE id_emissor = ? 
                ORDER BY mensagem.data_mensagem DESC";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_padrinho);
        $stmt->execute();
        $result = $stmt->get_result();
        $mensagens = [];
        while ($mensagem = $result->fetch_assoc()) {
            $mensagens[] = $mensagem;
        }
        return $mensagens;
    }

    public function list_all_received_by_id($id_padrinho)
    {
        $sql = "SELECT * FROM mensagem 
                INNER JOIN padrinho ON mensagem.id_emissor = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON mensagem.id_apadrinhado = apadrinhado.id_apadrinhado 
                WHERE id_receptor = ? 
                ORDER BY mensagem.data_mensagem DESC";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_padrinho);
        $stmt->execute();
        $result = $stmt->get_result();
        $mensagens = [];
        while ($mensagem = $result->fetch_assoc()) {
            $mensagens[] = $mensagem;
        }
        return $mensagens;
    }

    public function delete($id_mensagem)
    {
        $sql = "DELETE FROM mensagem WHERE id_mensagem = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_mensagem);
        return $stmt->execute();
    }
}