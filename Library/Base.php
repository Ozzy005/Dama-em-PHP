<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Library;

class Base
{
    protected Dados $dados;

    public function __construct()
    {
        $this->dados = Dados::getInstance();
    }
}
