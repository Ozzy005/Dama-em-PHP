<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Views\Home;

use Core\Data;
use DOMDocument;

class Home
{
    private $home;

    public function __construct()
    {
        $this->home = file_get_contents('../App/Views/Home/template/home.html');
    }

    public function make()
    {
        $doc = new DOMDocument();
        $doc->loadHTML($this->home);

        $div = $doc->createElement('div');
        $div->setAttribute('class', 'start');

        $p1 = $doc->createElement('p','Bem vindo');
        $p2 = $doc->createElement('p','Jogo de Dama feito em PHP!');
        $p3 = $doc->createElement('p','Escolha a cor das suas peças');

        $form = $doc->createElement('form');
        $form->setAttribute('method', 'post');
        $form->setAttribute('action', 'index.php');
        $form->setAttribute('enctype', 'application/x-www-form-urlencoded');

        $input1 = $doc->createElement('input');
        $input1->setAttribute('type', 'text');
        $input1->setAttribute('id', 'color-chosen');
        $input1->setAttribute('name', 'color-chosen');

        $input2 = $doc->createElement('input');
        $input2->setAttribute('type', 'text');
        $input2->setAttribute('name', 'class');
        $input2->setAttribute('value', 'App\Controllers\Board');

        $button1 = $doc->createElement('button');
        $button1->setAttribute('type', 'submit');
        $button1->setAttribute('id', '2');
        $button1->setAttribute('class', 'color-black');
        $button1->setAttribute('name', 'method');
        $button1->setAttribute('value', 'mount');

        $button2 = $doc->createElement('button');
        $button2->setAttribute('type', 'submit');
        $button2->setAttribute('id', '1');
        $button2->setAttribute('class', 'color-white');
        $button2->setAttribute('name', 'method');
        $button2->setAttribute('value', 'mount');

        $form->appendChild($input1);
        $form->appendChild($input2);
        $form->appendChild($button1);
        $form->appendChild($button2);

        $div->appendChild($p1);
        $div->appendChild($p2);
        $div->appendChild($p3);
        $div->appendChild($form);

        $script = $doc->getElementsByTagName('script')->item(0);

        $doc->lastChild->childNodes->item(3)->insertBefore($div, $script);

        $this->home = $doc->saveHTML();
    }

    public function show()
    {
        print $this->home;
    }
}