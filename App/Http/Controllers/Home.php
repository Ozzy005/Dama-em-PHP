<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Http\Controllers;

use Library\Session;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Home
{
    public function reiniciar(): void
    {
        Session::destroy();
        $this->exibir();
    }

    public function exibir()
    {
        $loader = new FilesystemLoader('../App/views/home/');
        $twig = new Environment($loader);
        echo $twig->render('home.html');
    }
}
