<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Views\Board;

use Core\Data;
use DOMDocument;

class Board
{
    private $board;
    private $data;

    public function __construct()
    {
        $this->board= file_get_contents('../App/Views/Board/template/board.html');
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $doc = new DOMDocument();
        $doc->loadHTML($this->board);

        $main = $doc->createElement('div');
        $main->setAttribute('class', 'main');

        $panel_left = $this->panelLeft($doc);
        $board = $this->board($doc);
        $panel_right = $this->panelRight($doc);

        $main->appendChild($panel_left);
        $main->appendChild($board);
        $main->appendChild($panel_right);

        $script = $doc->getElementsByTagName('script')->item(0);

        $doc->lastChild->childNodes->item(3)->insertBefore($main, $script);

        $this->board = $doc->saveHTML();
    }

    private function panelLeft($doc )
    {
        [
            'turn' => $turn,
            'player-current-left' => $pcl,
            'message-error' => $msg_error
        ] = $this->data->getData();

        $panel_left = $doc->createElement('div');
        $panel_left->setAttribute('class','panel-left');

        $control = $doc->createElement('div');
        $control->setAttribute('class','control');

        $form = $doc->createElement('form');
        $form->setAttribute('id','form');
        $form->setAttribute('method','post');
        $form->setAttribute('action','index.php');
        $form->setAttribute('enctype','application/x-www-form-urlencoded');

        $input1 = $doc->createElement('input');
        $input1->setAttribute('type','text');
        $input1->setAttribute('id','piece');
        $input1->setAttribute('name','piece');

        $input2 = $doc->createElement('input');
        $input2->setAttribute('type','text');
        $input2->setAttribute('id','line-source');
        $input2->setAttribute('name','line-source');

        $input3 = $doc->createElement('input');
        $input3->setAttribute('type','text');
        $input3->setAttribute('id','column-source');
        $input3->setAttribute('name','column-source');

        $input4 = $doc->createElement('input');
        $input4->setAttribute('type','text');
        $input4->setAttribute('id','line-target');
        $input4->setAttribute('name','line-target');

        $input5 = $doc->createElement('input');
        $input5->setAttribute('type','text');
        $input5->setAttribute('id','column-target');
        $input5->setAttribute('name','column-target');

        $input6 = $doc->createElement('input');
        $input6->setAttribute('type', 'text');
        $input6->setAttribute('name', 'class');
        $input6->setAttribute('value', 'App\Controllers\Board');

        $button1 = $doc->createElement('button','MOVE');
        $button1->setAttribute('type','submit');
        $button1->setAttribute('name','method');
        $button1->setAttribute('value','move');

        $button2 = $doc->createElement('button','RESET');
        $button2->setAttribute('type','submit');
        $button2->setAttribute('name','method');
        $button2->setAttribute('value','reset');

        $form->appendChild($input1);
        $form->appendChild($input2);
        $form->appendChild($input3);
        $form->appendChild($input4);
        $form->appendChild($input5);
        $form->appendChild($input6);
        $form->appendChild($button1);
        $form->appendChild($button2);
        $control->appendChild($form);

        $information = $doc->createElement('div');
        $information->setAttribute('class','information');

        $turn_current = $doc->createElement('div', "Turno: $turn");
        $turn_current->setAttribute('class','turn-current');

        $player_current_left = $doc->createElement('div', "Jogador: $pcl");
        $player_current_left->setAttribute('class','player-current-left');

        $information->appendChild($turn_current);
        $information->appendChild($player_current_left);

        if($msg_error != null)
        {
            $message_error = $doc->createElement('div', $msg_error);
            $message_error ->setAttribute('class','message-error ');
            $information->appendChild($message_error);
        }

        $panel_left->appendChild($control);
        $panel_left->appendChild($information);

        return $panel_left;
    }

    private function board($doc)
    {
        $b = $this->data->getValue('board');

        $board = $doc->createElement('div');
        $board->setAttribute('class','board');

        for($l = 8 ; $l >= 0 ; $l--)
        {
            $line = $doc->createElement('div');
            $line->setAttribute('id', $l);
            $line->setAttribute('class', 'line');

            $span = $doc->createElement('div',$l);

            $column_indicative = $doc->createElement('div');
            $column_indicative->setAttribute('class', 'column-indicative');
            $column_indicative->appendChild($span);

            $line->appendChild($column_indicative);

            for($c = 97 ; $c <= 104 && $l >= 1 ; $c++)
            {
                $column = $doc->createElement('div');
                $column->setAttribute('id',$c);

                if($b->isBlack($l,$c))
                {
                    $column->setAttribute('class','column column-black');

                    if($b->notEmpty($l,$c))
                    {
                        $p = $b->getPiece($l,$c);

                        if($p->isBlack())
                        {
                            $piece = $doc->createElement('div');
                            $piece->setAttribute('id',$p->getId());
                            $piece->setAttribute('class','piece stone-black');
                        }
                        elseif($p->isWhite())
                        {
                            $piece = $doc->createElement('div');
                            $piece->setAttribute('id',$p->getId());
                            $piece->setAttribute('class','piece stone-white');
                        }

                        $column->appendChild($piece);
                    }
                }
                else
                {
                    $column->setAttribute('class','column column-white');
                }

                $line->appendChild($column);
            }

            if($l == 0)
            {
                for($c = 97 ; $c <= 104 ; $c++)
                {
                    $letter = strtoupper(chr($c));
                    $span = $doc->createElement('div',$letter);
                    $column_indicative = $doc->createElement('div');
                    $column_indicative->setAttribute('class', 'column-indicative');
                    $column_indicative->appendChild($span);
                    $line->appendChild($column_indicative);
                }
            }

            $board->appendChild($line);
        }

        return $board;
    }

    public function panelRight($doc)
    {
        [
            'player-top-right' => $ptr,
            'player-current-top-right' => $pctr,
            'player-lower-right' => $plr,
            'player-current-lower-right' => $pclr
        ] = $this->data->getData();

        $panel_right = $doc->createElement('div');
        $panel_right->setAttribute('class','panel-right');

        $player_top_right = $doc->createElement('div');
        $player_top_right->setAttribute('class',"$pctr player-top-right");

        $span1 = $doc->createElement('span','J');
        $span2 = $doc->createElement('span','O');
        $span3 = $doc->createElement('span','G');
        $span4 = $doc->createElement('span','A');
        $span5 = $doc->createElement('span','D');
        $span6 = $doc->createElement('span','O');
        $span7 = $doc->createElement('span','R');
        $span8 = $doc->createElement('span',$ptr);

        $player_top_right->appendChild($span1);
        $player_top_right->appendChild($span2);
        $player_top_right->appendChild($span3);
        $player_top_right->appendChild($span4);
        $player_top_right->appendChild($span5);
        $player_top_right->appendChild($span6);
        $player_top_right->appendChild($span7);
        $player_top_right->appendChild($span8);

        $player_lower_right = $doc->createElement('div');
        $player_lower_right->setAttribute('class',"$pclr player-lower-right");

        $span1 = $doc->createElement('span','J');
        $span2 = $doc->createElement('span','O');
        $span3 = $doc->createElement('span','G');
        $span4 = $doc->createElement('span','A');
        $span5 = $doc->createElement('span','D');
        $span6 = $doc->createElement('span','O');
        $span7 = $doc->createElement('span','R');
        $span8 = $doc->createElement('span',$plr);

        $player_lower_right->appendChild($span1);
        $player_lower_right->appendChild($span2);
        $player_lower_right->appendChild($span3);
        $player_lower_right->appendChild($span4);
        $player_lower_right->appendChild($span5);
        $player_lower_right->appendChild($span6);
        $player_lower_right->appendChild($span7);
        $player_lower_right->appendChild($span8);

        $panel_right->appendChild($player_top_right);
        $panel_right->appendChild($player_lower_right);

        return $panel_right;
    }

    public function show()
    {
        print $this->board;
    }
}