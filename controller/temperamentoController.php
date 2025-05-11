<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/temperamento.php';

class TemperamentoController
{
    private $temperamento;

    public function __construct()
    {
        $this->temperamento = new Temperamento();
    }

    public function list_all()
    {
        return $this->temperamento->list_all();
    }

    public function search_by_id($id_temperamento)
    {
        return $this->temperamento->search_by_id($id_temperamento);
    }
}

new TemperamentoController();