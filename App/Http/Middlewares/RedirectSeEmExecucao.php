<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Http\Middlewares;
use Library\Session;

class RedirectSeEmExecucao
{
    public static function handle(): void
    {
        if (Session::has('jogoIniciado')) {
            header('Location: /dama-em-php');
            die;
        }
    }
}
