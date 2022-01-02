<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Library;

use Exception;

class Validar
{
    public static function jogador($id): void
    {
        if (!preg_match('/^[1-2]$/', $id)) {
            throw new Exception('Dados Recebidos Inválidos');
        }
    }

    public static function peca($id): void
    {
        if (!preg_match('/^[1-9]$|^[1-9][0-2]$/', $id)) {
            throw new Exception("Dados Recebidos Inválidos");
        }
    }

    public static function casa($l, $c): void
    {
        if (!preg_match('/^[1-8]$/', $l) || !preg_match('/^[9][7-9]$|^[1][0][0-4]$/', $c)) {
            throw new Exception("Dados Recebidos Inválidos");
        }
    }
}
