<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Controllers;

use App\Core\{Session, Father};
use App\Models\{Validation, Board as BoardModel, PlayerBoardSide, PlayerCurrent, Rules, Move};
use App\Views\Board\Board as BoardView;
use Exception;

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
        $borderView = new BoardView();
        $borderView->make();

        if(Session::empty('data')){
            $this->data->prepareToSave();
            Session::setValue('data', $this->data);
        };

        $borderView->show();
    }
}