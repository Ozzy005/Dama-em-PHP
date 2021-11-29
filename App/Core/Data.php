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
        $this->board = $data['board'] ?? null;
        $this->playerChosen = $data['player-chosen'] ?? Request::post('player-chosen');
        $this->turn = $data['turn'] ?? 1;
        $this->movementHistory = $data['movement-history'] ?? new MovementHistory;
        $this->cemetery = $data['cemetery'] ?? [];
        $this->playerCurrentLeft = $data['player-current-left'] ?? null;
        $this->playerTopRight = $data['player-top-right'] ?? null;
        $this->playerLowerRight = $data['player-lower-right'] ?? null;
        $this->playerCurrentTopRight = $data['player-current-top-right'] ?? null;
        $this->playerCurrentLowerRight = $data['player-current-lower-right'] ?? null;
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

    public function getData(){
        return [
            'board' => $this->board,
            'player-chosen' => $this->playerChosen,
            'turn' => $this->turn,
            'movement-history' => $this->movementHistory,
            'cemetery' => $this->cemetery,
            'player-current-left' => $this->playerCurrentLeft,
            'player-top-right' => $this->playerTopRight,
            'player-lower-right' => $this->playerLowerRight,
            'player-current-top-right' => $this->playerCurrentTopRight,
            'player-current-lower-right' => $this->playerCurrentLowerRight
        ];
    }
}