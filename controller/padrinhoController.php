<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/padrinho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/temperamento.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/comportamento.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/linguagem_amor.php';

class PadrinhoController
{
    private $padrinho;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->padrinho = new Padrinho();
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'update') {
                $this->update($_GET['id']);
                $this->refresh_session($_GET['id']);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            } else if ($_GET['action'] == 'change_password') {
                $this->change_password($_GET['id']);
                $this->refresh_session($_GET['id']);
                header('Location: ../minha_conta.php');
                exit;
            }
        }
    }

    private function refresh_session($id_padrinho)
    {
        $updatedData = $this->padrinho->search_by_id($id_padrinho);
        $_SESSION['id_padrinho'] = $id_padrinho;
        $_SESSION['nome'] = $updatedData['nome_padrinho'];
        $_SESSION['telefone'] = $updatedData['telefone_padrinho'];
        $_SESSION['descricao_perfil'] = $updatedData['descricao_padrinho'];
        $_SESSION['id_comportamento'] = $updatedData['id_comportamento'];
        $_SESSION['id_temperamento'] = $updatedData['id_temperamento'];
        $_SESSION['id_ling_amor'] = $updatedData['id_ling_amor'];
        $_SESSION['comportamento'] = $updatedData['nome_comportamento'];
        $_SESSION['linguagem'] = $updatedData['nome_linguagem'];
        $_SESSION['temperamento'] = $updatedData['nome_temperamento'];
        $_SESSION['usuario'] = $updatedData['usuario'];
        $_SESSION['status'] = $updatedData['status'];
    }

    public function list_all()
    {
        return $this->padrinho->list_all();
    }

    public function list_apadrinhados_by_padrinho($id_padrinho)
    {
        return $this->padrinho->list_apadrinhados_by_padrinho($id_padrinho);
    }

    public function search_by_id($id_padrinho)
    {
        return $this->padrinho->search_by_id($id_padrinho);
    }

    public function update($id_padrinho)
    {
        $comportamento = new Comportamento();
        $comportamento->setIdComportamento($_POST['comportamento']);
        $temperamento = new Temperamento();
        $temperamento->setIdTemperamento($_POST['temperamento']);
        $linguagem_amor = new Linguagem();
        $linguagem_amor->setIdLinguagem($_POST['linguagem']);

        $this->padrinho->setNome($_POST['nome']);
        $this->padrinho->setTelefone(preg_replace('/\D/', '', $_POST['phone']));
        $this->padrinho->setDescricaoPerfil($_POST['descricao']);
        $this->padrinho->setComportamento($comportamento);
        $this->padrinho->setTemperamento($temperamento);
        $this->padrinho->setLingAmor($linguagem_amor);
        $this->padrinho->update($id_padrinho);
    }

    public function change_password($id_padrinho)
    {
        $this->padrinho->setUsuario($_POST['usuario']);
        $this->padrinho->setSenha(md5($_POST['senha']));
        $this->padrinho->change_password($id_padrinho);
    }
}

new PadrinhoController();