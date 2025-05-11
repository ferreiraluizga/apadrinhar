<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Discipulado
{
    private $id_discipulado;
    private $padrinho;
    private $apadrinhado;
    private $data_discipulado;
    private $local_discipulado;
    private $descricao_discipulado;
    private $nivel_acesso;

    public function getIdDiscipulado()
    {
        return $this->id_discipulado;
    }

    public function setIdDiscipulado($id_discipulado)
    {
        $this->id_discipulado = $id_discipulado;
    }

    public function getPadrinho()
    {
        return $this->padrinho;
    }

    public function setPadrinho(Padrinho $padrinho)
    {
        $this->padrinho = $padrinho;
    }

    public function getApadrinhado()
    {
        return $this->apadrinhado;
    }

    public function setApadrinhado(Apadrinhado $apadrinhado)
    {
        $this->apadrinhado = $apadrinhado;
    }

    public function getDataDiscipulado()
    {
        return $this->data_discipulado;
    }

    public function setDataDiscipulado($data_discipulado)
    {
        $this->data_discipulado = $data_discipulado;
    }

    public function getLocalDiscipulado()
    {
        return $this->local_discipulado;
    }

    public function setLocalDiscipulado($local_discipulado)
    {
        $this->local_discipulado = $local_discipulado;
    }

    public function getDescricaoDiscipulado()
    {
        return $this->descricao_discipulado;
    }

    public function setDescricaoDiscipulado($descricao_discipulado)
    {
        $this->descricao_discipulado = $descricao_discipulado;
    }

    public function getNivelAcesso()
    {
        return $this->nivel_acesso;
    }

    public function setNivelAcesso($nivel_acesso)
    {
        $this->nivel_acesso = $nivel_acesso;
    }

    public function __construct()
    {
        $this->connect = new Connect();
    }

    public function insert()
    {
        $sql = "INSERT INTO discipulado (id_padrinho, id_apadrinhado, data_discipulado, local_discipulado, descricao_discipulado, nivel_acesso) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('iissss', $this->padrinho->getIdPadrinho(), $this->apadrinhado->getIdApadrinhado(), $this->data_discipulado, $this->local_discipulado, $this->descricao_discipulado, $this->nivel_acesso);
        return $stmt->execute();
    }

    public function list_all()
    {
        $sql = "SELECT discipulado.*, 
                    padrinho.nome_padrinho AS nome_padrinho, 
                    apadrinhado.nome_apadrinhado AS nome_apadrinhado,
                    feedback.id_feedback AS id_feedback
                FROM discipulado 
                INNER JOIN padrinho ON discipulado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON discipulado.id_apadrinhado = apadrinhado.id_apadrinhado 
                LEFT JOIN feedback ON discipulado.id_discipulado = feedback.id_discipulado ";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $discipulados = [];
        while ($discipulado = $result->fetch_assoc()) {
            $discipulados[] = $discipulado;
        }
        return $discipulados;
    }

    public function search_by_id($id_discipulado)
    {
        $sql = "SELECT discipulado.*,
                    padrinho.nome_padrinho AS nome_padrinho, 
                    apadrinhado.nome_apadrinhado AS nome_apadrinhado, 
                    apadrinhado.id_padrinho AS padrinho_apadrinhado
                FROM discipulado 
                INNER JOIN padrinho ON discipulado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON discipulado.id_apadrinhado = apadrinhado.id_apadrinhado
                WHERE discipulado.id_discipulado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_discipulado);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function search_latest()
    {
        $sql = "SELECT * FROM discipulado 
                INNER JOIN padrinho ON discipulado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON discipulado.id_apadrinhado = apadrinhado.id_apadrinhado 
                ORDER BY data_discipulado DESC 
                LIMIT 1";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function search_my_latest($id_padrinho)
    {
        $sql = "SELECT * FROM discipulado 
                INNER JOIN padrinho ON discipulado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON discipulado.id_apadrinhado = apadrinhado.id_apadrinhado 
                WHERE discipulado.id_padrinho = ? 
                ORDER BY data_discipulado DESC 
                LIMIT 1";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_padrinho);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function search_latest_apadrinhado($id_apadrinhado)
    {
        $sql = "SELECT * FROM discipulado 
                INNER JOIN padrinho ON discipulado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON discipulado.id_apadrinhado = apadrinhado.id_apadrinhado 
                WHERE discipulado.id_apadrinhado = ? 
                ORDER BY data_discipulado DESC 
                LIMIT 1";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_apadrinhado);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function search_pending()
    {
        $sql = "SELECT *, discipulado.id_discipulado AS id_discipulado FROM discipulado 
                INNER JOIN padrinho ON discipulado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON discipulado.id_apadrinhado = apadrinhado.id_apadrinhado
                LEFT JOIN feedback ON discipulado.id_discipulado = feedback.id_discipulado 
                WHERE feedback.id_discipulado IS NULL";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $discipulados = [];
        while ($discipulado = $result->fetch_assoc()) {
            $discipulados[] = $discipulado;
        }
        return $discipulados;
    }

    public function search_completed()
    {
        $sql = "SELECT * FROM discipulado 
                INNER JOIN padrinho ON discipulado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN apadrinhado ON discipulado.id_apadrinhado = apadrinhado.id_apadrinhado 
                INNER JOIN feedback ON discipulado.id_discipulado = feedback.id_discipulado";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $discipulados = [];
        while ($discipulado = $result->fetch_assoc()) {
            $discipulados[] = $discipulado;
        }
        return $discipulados;
    }

    public function update($id_discipulado)
    {
        $sql = "UPDATE discipulado SET id_padrinho = ?, id_apadrinhado = ?, data_discipulado = ?, local_discipulado = ?, descricao_discipulado = ?, nivel_acesso = ? WHERE id_discipulado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('iissssi', $this->padrinho->getIdPadrinho(), $this->apadrinhado->getIdApadrinhado(), $this->data_discipulado, $this->local_discipulado, $this->descricao_discipulado, $this->nivel_acesso, $id_discipulado);
        return $stmt->execute();
    }

    public function delete($id_discipulado)
    {
        $sql = "DELETE FROM discipulado WHERE id_discipulado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_discipulado);
        return $stmt->execute();
    }
}