<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Home{

    public function show(){
        $loader = new FilesystemLoader('../App/Views/Home/');
        $twig = new Environment($loader, ['strict_variables' => true]);
        echo $twig->render('home.html');
    }
}