<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/linguagem_amor.php';

class LinguagemController
{
    private $linguagem;

    public function __construct()
    {
        $this->linguagem = new Linguagem();
    }

    public function list_all()
    {
        return $this->linguagem->list_all();
    }

    public function search_by_id($id_linguagem)
    {
        return $this->linguagem->search_by_id($id_linguagem);
    }
}

new LinguagemController();