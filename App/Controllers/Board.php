<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Controllers;

use App\Core\{Session, Father};
use App\Models\{Validation, Board as BoardModel, PlayerBoardSide, PlayerCurrent, Rules, Move};
use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Board extends Father{

    public function mount(){
        try{
            $validation = new Validation();
            $validation->playerChosen();

            $boardModel = new BoardModel();
            $boardModel->make();

            $playerBoardSide = new PlayerBoardSide();
            $playerBoardSide->make();

            $playerCurrent = new PlayerCurrent();
            $playerCurrent->make();
        }
        catch(Exception $e){
            Session::destroy();
            header('Location: index.php');
        }
    }

    public function move(){
        try{
            $validation = new Validation();
            $validation->check();

            $rules = new Rules();
            $rules->check();

            $move = new Move();
            $move->make();

            $playerCurrent = new PlayerCurrent();
            $playerCurrent->make();
        }
        catch(Exception $e){
            $this->data->messageError = $e->getMessage();
        }
    }

    public function newGame(){
        Session::destroy();
        header('Location: index.php');
    }

    public function show(){
        $loader = new FilesystemLoader('../App/Views/Tabuleiro/');
        $twig = new Environment($loader, ['strict_variables' => true]);
        echo $twig->render('tabuleiro.html', ['data' => $this->data]);
        
        if(Session::empty('data')){
            Session::setValue('data', $this->data);
        };
    }
}