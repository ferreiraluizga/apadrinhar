<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/connect.php';

class Apadrinhado
{
    private $id_apadrinhado;
    private $nome;
    private $telefone;
    private $nascimento;
    private $descricao_perfil;
    private $padrinho;
    private $temperamento;
    private $comportamento;
    private $ling_amor;
    private $status_voluntario;
    private $batizado;
    private $redes;

    public function getIdApadrinhado()
    {
        return $this->id_apadrinhado;
    }

    public function setIdApadrinhado($id_apadrinhado)
    {
        $this->id_apadrinhado = $id_apadrinhado;
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

    public function getNascimento()
    {
        return $this->nascimento;
    }

    public function setNascimento($nascimento)
    {
        $this->nascimento = $nascimento;
    }

    public function getDescricaoPerfil()
    {
        return $this->descricao_perfil;
    }

    public function setDescricaoPerfil($descricao_perfil)
    {
        $this->descricao_perfil = $descricao_perfil;
    }

    public function getPadrinho()
    {
        return $this->padrinho;
    }

    public function setPadrinho(Padrinho $padrinho)
    {
        $this->padrinho = $padrinho;
    }

    public function getTemperamento()
    {
        return $this->temperamento;
    }

    public function setTemperamento(Temperamento $temperamento)
    {
        $this->temperamento = $temperamento;
    }

    public function getComportamento()
    {
        return $this->comportamento;
    }

    public function setComportamento(Comportamento $comportamento)
    {
        $this->comportamento = $comportamento;
    }

    public function getLingAmor()
    {
        return $this->ling_amor;
    }

    public function setLingAmor(Linguagem $ling_amor)
    {
        $this->ling_amor = $ling_amor;
    }

    public function getStatusVoluntario()
    {
        return $this->status_voluntario;
    }

    public function setStatusVoluntario($status_voluntario)
    {
        $this->status_voluntario = $status_voluntario;
    }

    public function getBatizado()
    {
        return $this->batizado;
    }

    public function setBatizado($batizado)
    {
        $this->batizado = $batizado;
    }

    public function __construct()
    {
        $this->connect = new Connect();
    }

    public function insert($redes, $ministerios)
    {
        $sql = "INSERT INTO apadrinhado (nome_apadrinhado, telefone_apadrinhado, nascimento_apadrinhado, descricao_apadrinhado, id_padrinho, id_temperamento, id_comportamento, id_ling_amor, status_voluntario, batizado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('ssssiiiisi', $this->nome, $this->telefone, $this->nascimento, $this->descricao_perfil, $this->padrinho->getIdPadrinho(), $this->temperamento->getIdTemperamento(), $this->comportamento->getIdComportamento(), $this->ling_amor->getIdLinguagem(), $this->status_voluntario, $this->batizado);
        $stmt->execute();
        $this->insertMinisterio($stmt->insert_id, $ministerios);
        return $this->insertSocial($stmt->insert_id, $redes);
    }

    public function insertSocial($id_apadrinhado, $redes)
    {
        for ($i = 1; $i < 5; $i++) {
            $sql = "INSERT INTO redes_apadr (id_apadrinhado, id_rede_social, complemento) VALUES (?, ?, ?)";
            $stmt = $this->connect->getConnect()->prepare($sql);
            $stmt->bind_param('iis', $id_apadrinhado, $i, $redes[$i]);
            $stmt->execute();
        }
    }

    public function insertMinisterio($id_apadrinhado, $ministerios)
    {
        foreach ($ministerios as $ministerio) {
            $sql = "INSERT INTO ministerio_apadr (id_apadrinhado, id_ministerio) VALUES (?, ?)";
            $stmt = $this->connect->getConnect()->prepare($sql);
            $stmt->bind_param('ii', $id_apadrinhado, $ministerio);
            $stmt->execute();
        }
    }

    public function list_all()
    {
        $sql = "SELECT * FROM apadrinhado 
                INNER JOIN padrinho ON apadrinhado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN temperamento ON apadrinhado.id_temperamento = temperamento.id_temperamento 
                INNER JOIN comportamento ON apadrinhado.id_comportamento = comportamento.id_comportamento 
                INNER JOIN linguagem_amor ON apadrinhado.id_ling_amor = linguagem_amor.id_linguagem 
                ORDER BY nome_apadrinhado";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $apadrinhados = [];
        while ($apadrinhado = $result->fetch_assoc()) {
            $apadrinhados[] = $apadrinhado;
        }
        return $apadrinhados;
    }

    public function search_by_id($id_apadrinhado)
    {
        $sql = "SELECT apadrinhado.*, padrinho.id_padrinho, padrinho.nome_padrinho, padrinho.telefone_padrinho, temperamento.*, comportamento.*, linguagem_amor.* FROM apadrinhado 
                INNER JOIN padrinho ON apadrinhado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN temperamento ON apadrinhado.id_temperamento = temperamento.id_temperamento 
                INNER JOIN comportamento ON apadrinhado.id_comportamento = comportamento.id_comportamento 
                INNER JOIN linguagem_amor ON apadrinhado.id_ling_amor = linguagem_amor.id_linguagem 
                WHERE apadrinhado.id_apadrinhado = ? 
                ORDER BY nome_apadrinhado";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_apadrinhado);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function search_by_name($nome)
    {
        $sql = "SELECT * FROM apadrinhado 
                INNER JOIN padrinho ON apadrinhado.id_padrinho = padrinho.id_padrinho 
                INNER JOIN temperamento ON apadrinhado.id_temperamento = temperamento.id_temperamento 
                INNER JOIN comportamento ON apadrinhado.id_comportamento = comportamento.id_comportamento 
                INNER JOIN linguagem_amor ON apadrinhado.id_ling_amor = linguagem_amor.id_linguagem 
                WHERE nome_apadrinhado LIKE ? 
                ORDER BY nome_apadrinhado";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $nome = '%' . $nome . '%';
        $stmt->bind_param('s', $nome);
        $stmt->execute();
        $result = $stmt->get_result();
        $apadrinhados = [];
        while ($apadrinhado = $result->fetch_assoc()) {
            $apadrinhados[] = $apadrinhado;
        }
        return $apadrinhados;
    }

    public function search_socials_by_id($id_apadrinhado)
    {
        $sql = "SELECT 
                redes_apadr.id_rede_social, 
                redes_apadr.complemento 
            FROM redes_apadr
            WHERE id_apadrinhado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_apadrinhado);
        $stmt->execute();
        $result = $stmt->get_result();
        $socials = [];
        while ($row = $result->fetch_assoc()) {
            switch ($row['id_rede_social']) {
                case 1:
                    $socials['instagram'] = $row['complemento'];
                    break;
                case 2:
                    $socials['facebook'] = $row['complemento'];
                    break;
                case 3:
                    $socials['twitter'] = $row['complemento'];
                    break;
                case 4:
                    $socials['tiktok'] = $row['complemento'];
                    break;
            }
        }
        return $socials;
    }

    public function search_ministerios_by_id($id_apadrinhado)
    {
        $sql = "SELECT * FROM ministerio_apadr
                INNER JOIN ministerio ON ministerio_apadr.id_ministerio = ministerio.id_ministerio 
                WHERE id_apadrinhado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_apadrinhado);
        $stmt->execute();
        $result = $stmt->get_result();
        $ministerios_apadr = [];
        while ($minsterio = $result->fetch_assoc()) {
            $ministerios_apadr[] = $minsterio;
        }
        return $ministerios_apadr;
    }

    public function update($id_apadrinhado, $redes, $ministerios)
    {
        $this->delete_redes($id_apadrinhado);
        $this->delete_ministerios($id_apadrinhado);
        $sql = "UPDATE apadrinhado SET nome_apadrinhado = ?, telefone_apadrinhado = ?, nascimento_apadrinhado = ?, descricao_apadrinhado = ?, id_padrinho = ?, id_temperamento = ?, id_comportamento = ?, id_ling_amor = ?, status_voluntario = ?, batizado = ? WHERE id_apadrinhado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $padrinhoId = $this->padrinho->getIdPadrinho();
        $temperamentoId = $this->temperamento->getIdTemperamento();
        $comportamentoId = $this->comportamento->getIdComportamento();
        $lingAmorId = $this->ling_amor->getIdLinguagem();   
        $stmt->bind_param('ssssiiiisii', $this->nome, $this->telefone, $this->nascimento, $this->descricao_perfil, $padrinhoId, $temperamentoId, $comportamentoId, $lingAmorId, $this->status_voluntario, $this->batizado, $id_apadrinhado);
        $stmt->execute();
        $this->insertMinisterio($id_apadrinhado, $ministerios);
        return $this->insertSocial($id_apadrinhado, $redes);
    }

    public function delete_redes($id_apadrinhado)
    {
        $sql = "DELETE FROM redes_apadr WHERE id_apadrinhado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_apadrinhado);
        return $stmt->execute();
    }

    public function delete_ministerios($id_apadrinhado)
    {
        $sql = "DELETE FROM ministerio_apadr WHERE id_apadrinhado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_apadrinhado);
        return $stmt->execute();
    }

    public function delete($id_apadrinhado)
    {
        $this->delete_redes($id_apadrinhado);
        $this->delete_ministerios($id_apadrinhado);
        $sql = "DELETE FROM apadrinhado WHERE id_apadrinhado = ?";
        $stmt = $this->connect->getConnect()->prepare($sql);
        $stmt->bind_param('i', $id_apadrinhado);
        return $stmt->execute();
    }
}
