<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use App\Core\Father;
use Exception;

class Rules extends Father{
    
    private $paths = [];
    private $pathBase = [];
    private $ignored = [];
    private $option = 1;
    private $depthLevel = 0;
    private $depthLevelMax = 0;

    public function check(){
        $mh = $this->data->movementHistory;
        $pChosen = $this->data->playerChosen;
        $board = $this->data->board;
        $pAtt = $this->data->pieceAttacking;
        $lSrc = $this->data->lineSource;
        $cSrc = $this->data->columnSource;
        $lDst = $this->data->lineDestiny;
        $cDst = $this->data->columnDestiny;

        try{
            $this->whoseTurn($mh, $pAtt);
            if($this->movement($pChosen, $board, $pAtt, $lSrc, $cSrc, $lDst, $cDst)){return true;}
            if($this->capture($board, $pAtt, $lSrc, $cSrc, $lDst, $cDst)){return true;}
            else{throw new Exception('Movimento Inválido');}
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function whoseTurn($mh, $pAtt){
        $pLastMove = $mh->getLastMove();

        if($pLastMove && $pLastMove['piece-attacking']->color == $pAtt->color){
            throw new Exception('Não é sua vez de jogar');
        }
        elseif(!$pLastMove && $pAtt->isBlack()){
            throw new Exception('Cor branca deve fazer o lance inicial');
        }
    }

    private function movement($pChosen, $board, $pAtt, $lSrc, $cSrc, $lDst, $cDst){
        for($n = 1 ; $n <= 4 ; $n++){
            if($n == 1){
                $l = $lSrc + 1;
                $c = $cSrc - 1;
            }
            elseif($n == 2){
                $l = $lSrc + 1;
                $c = $cSrc + 1;
            }
            elseif($n == 3){
                $l = $lSrc - 1;
                $c = $cSrc - 1;
            }
            elseif($n == 4){
                $l = $lSrc - 1;
                $c = $cSrc + 1;
            }

            if($this->checkLineColumn($l, $c) && $board->isEmpty($l, $c) && $l == $lDst && $c == $cDst){
                if($pChosen == 1){
                    if($pAtt->isWhite() && $lSrc < $lDst){
                        $this->data->moveType = 'movePiece';
                        return true;
                    }
                    elseif($pAtt->isBlack() && $lSrc > $lDst){
                        $this->data->moveType = 'movePiece';
                        return true;
                    }
                }
                elseif($pChosen == 2){
                    if($pAtt->isBlack() && $lSrc < $lDst){
                        $this->data->moveType = 'movePiece';
                        return true;
                    }
                    elseif($pAtt->isWhite() && $lSrc > $lDst){
                        $this->data->moveType = 'movePiece';
                        return true;
                    }
                }
            }
        }
    }

    private function capture($board, $pAtt, $lSrc, $cSrc, $lDst, $cDst){
        for($n = 1 ; $n <= 4 ; $n++){
            if($n == 1){
                $direction = 'north-west';
                $l1 = $lSrc + 1;
                $c1 = $cSrc - 1;
                $l2 = $lSrc + 2;
                $c2 = $cSrc - 2;
            }
            elseif($n == 2){
                $direction = 'north-east';
                $l1 = $lSrc + 1;
                $c1 = $cSrc + 1;
                $l2 = $lSrc + 2;
                $c2 = $cSrc + 2;
            }
            elseif($n == 3){
                $direction = 'south-west';
                $l1 = $lSrc - 1;
                $c1 = $cSrc - 1;
                $l2 = $lSrc - 2;
                $c2 = $cSrc - 2;
            }
            elseif($n == 4){
                $direction = 'south-east';
                $l1 = $lSrc - 1;
                $c1 = $cSrc + 1;
                $l2 = $lSrc - 2;
                $c2 = $cSrc + 2;
            }

            if($this->checkLineColumn($l1, $c1) && $this->checkLineColumn($l2, $c2)){
                if($board->notEmpty($l1, $c1) && $board->isEmpty($l2, $c2) && $board->getPiece($l1, $c1)->color != $pAtt->color){
                    $ignoredId = 0;
                    $pEnemy = $board->getPiece($l1, $c1);

                    for($i = 0; $i < count($this->ignored); $i++){
                        $ignoredId = $this->ignored[$i]->id;
                        if($pEnemy->id == $ignoredId){break;}
                    }

                    if($pEnemy->id != $ignoredId){
                        if($this->depthLevel < $this->depthLevelMax){
                            $this->option++;
                            $this->paths[$this->option] = array_merge($this->pathBase);
                        }

                        $this->depthLevelMax = ++$this->depthLevel;
                        $this->ignored[] = $pEnemy;
                        $this->pathBase[] = $this->paths[$this->option][] = [
                            'l-src' => $lSrc,
                            'c-src' => $cSrc,
                            'p-enemy' => $pEnemy,
                            'l-mdw' => $l1,
                            'c-mdw' => $c1,
                            'l-dst' => $l2,
                            'c-dst' => $c2
                        ];
                        $lSrc = $l2;
                        $cSrc = $c2;

                        $this->capture($board, $pAtt, $lSrc, $cSrc, $lDst, $cDst);

                        if($direction == 'north-west'){$lSrc -= 2; $cSrc += 2;}
                        elseif($direction == 'north-east'){$lSrc -= 2; $cSrc -= 2;}
                        elseif($direction == 'south-west'){$lSrc += 2; $cSrc += 2;}
                        elseif($direction == 'south-east'){$lSrc += 2; $cSrc -= 2;}
                    }
                }
            }
        }

        array_pop($this->pathBase);
        array_pop($this->ignored);
        $this->depthLevel--;

        if($this->depthLevel == -1 && count($this->paths) > 0){
            $optionsCounted = array_map('count', $this->paths);
            $bestOptions = array_keys($optionsCounted , max($optionsCounted));

            if(count($bestOptions) == 1){
                $option = $bestOptions[0];
                $lastPath = end($this->paths[$option]);

                if($lastPath['l-dst'] == $lDst && $lastPath['c-dst'] == $cDst){
                    $this->data->moveType = 'capturePiece';
                    $piecesCaptured = [];

                    foreach($this->paths[$option] as $path){
                        $piecesCaptured[] = [
                            'piece-captured' => $path['p-enemy'],
                            'line-midway' => $path['l-mdw'],
                            'column-midway' => $path['c-mdw']
                        ];
                    }

                    $this->data->piecesCaptured = $piecesCaptured;
                    return true;
                }
            }
            elseif(count($bestOptions) > 1){
                foreach($bestOptions as $option){
                    $lastPath = end($this->paths[$option]);

                    if($lastPath['l-dst'] == $lDst && $lastPath['c-dst'] == $cDst){
                        $this->data->moveType = 'capturePiece';
                        $piecesCaptured = [];

                        foreach($this->paths[$option] as $path){
                            $piecesCaptured[] = [
                                'piece-captured' => $path['p-enemy'],
                                'line-midway' => $path['l-mdw'],
                                'column-midway' => $path['c-mdw']
                            ];
                        }

                        $this->data->piecesCaptured = $piecesCaptured;
                        return true;
                    }
                }
            }
        }
    }

    private function checkLineColumn($l, $c){
        if($l >= 1 && $l <= 8 && $c >= 97 && $c <= 104){
            return true;
        }
    }
}
