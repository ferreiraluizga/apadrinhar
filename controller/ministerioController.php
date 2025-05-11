<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/model/ministerio.php';

class MinisterioController
{
    private $ministerio;

    public function __construct()
    {
        $this->ministerio = new Ministerio();
    }

    public function list_all()
    {
        return $this->ministerio->list_all();
    }

    public function search_by_id($id_ministerio)
    {
        return $this->ministerio->search_by_id($id_ministerio);
    }
}

new MinisterioController();