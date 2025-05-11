<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/comportamento.php';

class ComportamentoController
{
    private $comportamento;

    public function __construct()
    {
        $this->comportamento = new Comportamento();
    }

    public function list_all()
    {
        return $this->comportamento->list_all();
    }

    public function search_by_id($id_comportamento)
    {
        return $this->comportamento->search_by_id($id_comportamento);
    }
}

new ComportamentoController();