<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Padrinho
{
    private $id_padrinho;
    private $nome;
    private $telefone;
    private $descricao_perfil;
    private $comportamento;
    private $temperamento;
    private $ling_amor;
    private $usuario;
    private $senha;

    public function getIdPadrinho()
    {
        return $this->id_padrinho;
    }

    public function setIdPadrinho($id_padrinho)
    {
        $this->id_padrinho = $id_padrinho;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getDescricaoPerfil()
    {
        return $this->descricao_perfil;
    }

    public function setDescricaoPerfil($descricao_perfil)
    {
        $this->descricao_perfil = $descricao_perfil;
    }

    public function getComportamento()
    {
        return $this->comportamento;
    }

    public function setComportamento(Comportamento $comportamento)
    {
        $this->comportamento = $comportamento;
    }

    public function getTemperamento()
    {
        return $this->temperamento;
    }

    public function setTemperamento(Temperamento $temperamento)
    {
        $this->temperamento = $temperamento;
    }

    public function getLingAmor()
    {
        return $this->ling_amor;
    }

    public function setLingAmor(Linguagem $ling_amor)
    {
        $this->ling_amor = $ling_amor;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function __construct()
    {
        $this->connect = new Connect();
    }

    public function list_all()
    {
        $sql = "SELECT * FROM padrinho
                INNER JOIN temperamento ON padrinho.id_temperamento = temperamento.id_temperamento 
                INNER JOIN comportamento ON padrinho.id_comportamento = comportamento.id_comportamento 
                INNER JOIN linguagem_amor ON padrinho.id_ling_amor = linguagem_amor.id_linguagem ";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $padrinhos = [];
        while ($padrinho = $result->fetch_assoc()) {
            $padrinhos[] = $padrinho;
        }
        return $padrinhos;
    }

    public function list_apadrinhados_by_padrinho($id_padrinho)
    {
        $sql = "SELECT apadrinhado.* 
            FROM apadrinhado
            INNER JOIN padrinho ON apadrinhado.id_padrinho = padrinho.id_padrinho
            WHERE apadrinhado.id_padrinho = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_padrinho);
        $stmt->execute();
        $result = $stmt->get_result();

        $apadrinhados = [];
        while ($apadrinhado = $result->fetch_assoc()) {
            $apadrinhados[] = $apadrinhado;
        }

        return $apadrinhados;
    }


    public function search_by_id($id_padrinho)
    {
        $sql = "SELECT * FROM padrinho
                INNER JOIN temperamento ON padrinho.id_temperamento = temperamento.id_temperamento 
                INNER JOIN comportamento ON padrinho.id_comportamento = comportamento.id_comportamento 
                INNER JOIN linguagem_amor ON padrinho.id_ling_amor = linguagem_amor.id_linguagem 
                WHERE id_padrinho = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_padrinho);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($id_padrinho)
    {
        $sql = "UPDATE padrinho SET nome_padrinho = ?, telefone_padrinho = ?, descricao_padrinho = ?, id_temperamento = ?, id_comportamento = ?, id_ling_amor = ? WHERE id_padrinho = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('sssiiii', $this->nome, $this->telefone, $this->descricao_perfil, $this->temperamento->getIdTemperamento(), $this->comportamento->getIdComportamento(), $this->ling_amor->getIdLinguagem(), $id_padrinho);
        return $stmt->execute();
    }

    public function change_password($id_padrinho)
    {
        $sql = "UPDATE padrinho SET usuario = ?, senha = ? WHERE id_padrinho = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('ssi', $this->usuario, $this->senha, $id_padrinho);
        return $stmt->execute();
    }
}
