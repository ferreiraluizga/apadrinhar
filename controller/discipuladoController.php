<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/apadrinhado.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/padrinho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/discipulado.php';

class DiscipuladoController
{
    private $discipulado;

    public function __construct()
    {
        $this->discipulado = new Discipulado();
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'insert') {
                $this->insert();
                header('Location: ../cadastrar_discipulado.php?status=completed');
                exit;
            } else if ($_GET['action'] == 'update') {
                $this->update($_GET['id']);
                header('Location: ../discipulados.php');
                exit;
            } else if ($_GET['action'] == 'delete') {
                
            }
        }
    }

    public function insert()
    {
        $padrinho = new Padrinho();
        $padrinho->setIdPadrinho($_POST['padrinho']);
        $apadrinhado = new Apadrinhado();
        $apadrinhado->setIdApadrinhado($_POST['apadrinhado']);
        
        if ($_POST['nivel_acesso'] == null) {
            $nivel_acesso = 'publico';
        } else {
            $nivel_acesso = 'privado';
        }

        $this->discipulado->setApadrinhado($apadrinhado);
        $this->discipulado->setPadrinho($padrinho);
        $this->discipulado->setDataDiscipulado($_POST['data']);
        $this->discipulado->setLocalDiscipulado($_POST['local']);
        $this->discipulado->setDescricaoDiscipulado($_POST['descricao']);
        $this->discipulado->setNivelAcesso($nivel_acesso);
        $this->discipulado->insert();
    }

    public function list_all()
    {
        return $this->discipulado->list_all();
    }

    public function search_by_id($id_discipulado)
    {
        return $this->discipulado->search_by_id($id_discipulado);
    }

    public function search_latest()
    {
        return $this->discipulado->search_latest();
    }

    public function search_my_latest($id_padrinho)
    {
        return $this->discipulado->search_my_latest($id_padrinho);
    }

    public function search_latest_apadrinhado($id_apadrinhado)
    {
        return $this->discipulado->search_latest_apadrinhado($id_apadrinhado);
    }

    public function search_pending()
    {
        return $this->discipulado->search_pending();
    }

    public function search_completed()
    {
        return $this->discipulado->search_completed();
    }

    public function update($id_discipulado)
    {
        $padrinho = new Padrinho();
        $padrinho->setIdPadrinho($_POST['padrinho']);
        $apadrinhado = new Apadrinhado();
        $apadrinhado->setIdApadrinhado($_POST['apadrinhado']);
        
        if ($_POST['nivel_acesso'] == null) {
            $nivel_acesso = 'publico';
        } else {
            $nivel_acesso = 'privado';
        }

        $this->discipulado->setApadrinhado($apadrinhado);
        $this->discipulado->setPadrinho($padrinho);
        $this->discipulado->setDataDiscipulado($_POST['data']);
        $this->discipulado->setLocalDiscipulado($_POST['local']);
        $this->discipulado->setDescricaoDiscipulado($_POST['descricao']);
        $this->discipulado->setNivelAcesso($nivel_acesso);
        $this->discipulado->update($id_discipulado);
    }
}

new DiscipuladoController();
