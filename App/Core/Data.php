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
    public $turn;
    public $movementHistory;
    public $cemetery;
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
    public $piecesCaptured;
    public $messageError;

    private function __construct(){
        $data = Session::getValue('data');
        $this->board = $data->board ?? null;
        $this->playerChosen = $data->playerChosen ?? Request::post('player-chosen');
        $this->turn = $data->turn ?? 1;
        $this->movementHistory = $data->movementHistory ?? new MovementHistory;
        $this->cemetery = $data->cemetery ?? [];
        $this->playerCurrentLeft = $data->playerCurrentLeft ?? null;
        $this->playerTopRight = $data->playerTopRight ?? null;
        $this->playerLowerRight = $data->playerLowerRight ?? null;
        $this->playerCurrentTopRight = $data->playerCurrentTopRight ?? null;
        $this->playerCurrentLowerRight = $data->playerCurrentLowerRight ?? null;
        $this->pieceAttackingId = Request::post('piece-attacking');
        $this->lineSource =  Request::post('line-source');
        $this->columnSource = Request::post('column-source');
        $this->lineDestiny = Request::post('line-destiny');
        $this->columnDestiny = Request::post('column-destiny');
    }

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function prepareToSave(){
        $this->pieceAttacking = null;
        $this->pieceAttackingId = null;
        $this->lineSource = null;
        $this->columnSource = null;
        $this->lineDestiny = null;
        $this->columnDestiny = null;
        $this->moveType = null;
        $this->piecesCaptured = null;
        $this->messageError = null;
    }
}