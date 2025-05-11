<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/padrinho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/mensagem.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/apadrinhado.php';

class MensagemController
{
    private $mensagem;

    public function __construct()
    {
        $this->mensagem = new Mensagem();
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
        $padrinho_emissor = new Padrinho();
        $padrinho_emissor->setIdPadrinho($_POST['padrinho_emissor']);

        $padrinho_receptor = new Padrinho();
        $padrinho_receptor->setIdPadrinho($_POST['padrinho_receptor']);

        $apadrinhado = new Apadrinhado();
        $apadrinhado->setIdApadrinhado($_POST['apadrinhado']);

        $this->mensagem->setPadrinhoEmissor($padrinho_emissor);
        $this->mensagem->setPadrinhoReceptor($padrinho_receptor);
        $this->mensagem->setApadrinhado($apadrinhado);
        $this->mensagem->setMensagem($_POST['mensagem']);
        $this->mensagem->insert();
    }

    public function list_all_sended_by_id($id_padrinho)
    {
        return $this->mensagem->list_all_sended_by_id($id_padrinho);
    }

    public function list_all_received_by_id($id_padrinho)
    {
        return $this->mensagem->list_all_received_by_id($id_padrinho);
    }

    public function delete($id_mensagem)
    {
        $this->mensagem->delete($id_mensagem);
    }

}

new MensagemController();