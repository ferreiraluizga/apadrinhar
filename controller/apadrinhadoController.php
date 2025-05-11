<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/apadrinhado.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/padrinho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/temperamento.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/comportamento.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/linguagem_amor.php';

class ApadrinhadoController
{
    private $apadrinhado;

    public function __construct()
    {
        $this->apadrinhado = new Apadrinhado();
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'insert') {
                $this->insert();
                header('Location: ../cadastrar_apadrinhado.php?status=completed');
                exit;
            } else if ($_GET['action'] == 'update') {
                $this->update($_GET['id']);
                header('Location: ../apadrinhados.php');
                exit;
            } else if ($_GET['action'] == 'delete') {
                $this->delete($_GET['id']);
                header('Location: ../apadrinhados.php');
                exit;
            }
        }
    }

    public function insert()
    {
        $comportamento = new Comportamento();
        $comportamento->setIdComportamento($_POST['comportamento']);
        $temperamento = new Temperamento();
        $temperamento->setIdTemperamento($_POST['temperamento']);
        $linguagem_amor = new Linguagem();
        $linguagem_amor->setIdLinguagem($_POST['linguagem']);
        $padrinho = new Padrinho();
        $padrinho->setIdPadrinho($_POST['padrinho']);

        $redes = [];
        if (!empty($_POST['instagram'])) {
            $redes[1] = $_POST['instagram'];
        } else {
            $redes[1] = 'Não Possui';
        }
        if (!empty($_POST['facebook'])) {
            $redes[2] = $_POST['facebook'];
        } else {
            $redes[2] = 'Não Possui';
        }
        if (!empty($_POST['twitter'])) {
            $redes[3] = $_POST['twitter'];
        } else {
            $redes[3] = 'Não Possui';
        }
        if (!empty($_POST['tiktok'])) {
            $redes[4] = $_POST['tiktok'];
        } else {
            $redes[4] = 'Não Possui';
        }

        $ministerios = [];
        $ministerios = $_POST['ministerios'];

        $this->apadrinhado->setNome($_POST['nome']);
        $this->apadrinhado->setTelefone(preg_replace('/\D/', '', $_POST['phone']));
        $this->apadrinhado->setNascimento($_POST['nasc']);
        $this->apadrinhado->setDescricaoPerfil($_POST['descricao']);
        $this->apadrinhado->setPadrinho($padrinho);
        $this->apadrinhado->setTemperamento($temperamento);
        $this->apadrinhado->setComportamento($comportamento);
        $this->apadrinhado->setLingAmor($linguagem_amor);
        $this->apadrinhado->setBatizado($_POST['batizado']);
        $this->apadrinhado->setStatusVoluntario($_POST['voluntario']);
        $this->apadrinhado->insert($redes, $ministerios);
    }

    public function list_all()
    {
        return $this->apadrinhado->list_all();
    }

    public function search_by_id($id_apadrinhado)
    {
        return $this->apadrinhado->search_by_id($id_apadrinhado);
    }

    public function search_by_name($nome_apadrinhado)
    {
        return $this->apadrinhado->search_by_name($nome_apadrinhado);
    }

    public function search_socials_by_id($id_apadrinhado)
    {
        return $this->apadrinhado->search_socials_by_id($id_apadrinhado);
    }

    public function search_ministerios_by_id($id_apadrinhado)
    {
        return $this->apadrinhado->search_ministerios_by_id($id_apadrinhado);
    }

    public function update($id_apadrinhado)
    {
        $comportamento = new Comportamento();
        $comportamento->setIdComportamento($_POST['comportamento']);
        $temperamento = new Temperamento();
        $temperamento->setIdTemperamento($_POST['temperamento']);
        $linguagem_amor = new Linguagem();
        $linguagem_amor->setIdLinguagem($_POST['linguagem']);
        $padrinho = new Padrinho();
        $padrinho->setIdPadrinho($_POST['padrinho']);

        $redes = [];
        if (!empty($_POST['instagram'])) {
            $redes[1] = $_POST['instagram'];
        } else {
            $redes[1] = 'Não Possui';
        }
        if (!empty($_POST['facebook'])) {
            $redes[2] = $_POST['facebook'];
        } else {
            $redes[2] = 'Não Possui';
        }
        if (!empty($_POST['twitter'])) {
            $redes[3] = $_POST['twitter'];
        } else {
            $redes[3] = 'Não Possui';
        }
        if (!empty($_POST['tiktok'])) {
            $redes[4] = $_POST['tiktok'];
        } else {
            $redes[4] = 'Não Possui';
        }

        $ministerios = [];
        $ministerios = $_POST['ministerios'];

        $this->apadrinhado->setNome($_POST['nome']);
        $this->apadrinhado->setTelefone(preg_replace('/\D/', '', $_POST['phone']));
        $this->apadrinhado->setNascimento($_POST['nasc']);
        $this->apadrinhado->setDescricaoPerfil($_POST['descricao']);
        $this->apadrinhado->setPadrinho($padrinho);
        $this->apadrinhado->setTemperamento($temperamento);
        $this->apadrinhado->setComportamento($comportamento);
        $this->apadrinhado->setLingAmor($linguagem_amor);
        $this->apadrinhado->setBatizado($_POST['batizado']);
        $this->apadrinhado->setStatusVoluntario($_POST['voluntario']);
        $this->apadrinhado->update($id_apadrinhado, $redes, $ministerios);
    }

    public function delete($id_apadrinhado)
    {
        $this->apadrinhado->delete($id_apadrinhado);
    }
}

new ApadrinhadoController();
