<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Core;

class Data{
    
    private static $instance;
    public $board;
    public $playerChosen;
    public $turn = 1;
    public $movementHistory;
    public $cemetery = [];
    public $playerCurrentLeft;
    public $playerTopRight;
    public $playerLowerRight;
    public $playerCurrentTopRight;
    public $playerCurrentLowerRight;
    public $pieceAttacking;
    public $pieceAttackingId;
    public $lineSource;
    public $columnSource;
    public $lineDestiny;
    public $columnDestiny;
    public $moveType;
    public $targetPieces;
    public $messageError;

    private function __construct(){
        if(Session::empty('data')){
            $this->playerChosen = Request::post('player-chosen');
            $this->movementHistory = new MovementHistory;
        }
    }

    public function __wakeup(){
        $this->pieceAttackingId = Request::post('piece-attacking');
        $this->lineSource =  Request::post('line-source');
        $this->columnSource = Request::post('column-source');
        $this->lineDestiny = Request::post('line-destiny');
        $this->columnDestiny = Request::post('column-destiny');
        self::$instance = $this;
    }

    public function __sleep(){
        return [
           'board',
           'playerChosen',
           'turn',
           'movementHistory',
           'cemetery',
           'playerCurrentLeft',
           'playerTopRight',
           'playerLowerRight',
           'playerCurrentTopRight',
           'playerCurrentLowerRight'
        ];
    }

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;
    }
}