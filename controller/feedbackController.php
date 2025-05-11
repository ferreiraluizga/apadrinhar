<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/feedback.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/padrinho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/discipulado.php';

class FeedbackController
{
    private $feedback;

    public function __construct()
    {
        $this->feedback = new Feedback();
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'insert') {
                $this->insert();
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            } else if ($_GET['action'] == 'delete') {
                $this->delete($_GET['id']);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

    public function insert()
    {
        $padrinho = new Padrinho();
        $padrinho->setIdPadrinho($_POST['padrinho']);
        $discipulado = new Discipulado();
        $discipulado->setIdDiscipulado($_POST['discipulado']);

        $this->feedback->setPadrinho($padrinho);
        $this->feedback->setDiscipulado($discipulado);
        $this->feedback->setDescricao($_POST['descricao']);
        $this->feedback->setAvaliacao($_POST['avaliacao']);
        $this->feedback->insert();
    }

    public function list_all_by_id($id_discipulado)
    {
        return $this->feedback->list_all_by_id($id_discipulado);
    }

    public function delete($id_feedback)
    {
        $this->feedback->delete($id_feedback);
    }

}

new FeedbackController();