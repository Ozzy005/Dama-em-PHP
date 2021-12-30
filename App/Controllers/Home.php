<?php

/**
 *
 * @author Rafael Arend
 *
**/

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Home
{
    public function exibir()
    {
        $loader = new FilesystemLoader('../App/Views/Home/');
        $twig = new Environment($loader);
        echo $twig->render('Home.html');
    }
}
