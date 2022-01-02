<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Http\Middlewares;
use Library\Session;

class RedirectSeNaoEmExecucao
{
    public static function handle(): void
    {
        if (Session::notHas('jogoIniciado')) {
            header('Location: /home');
            die;
        }
    }
}
