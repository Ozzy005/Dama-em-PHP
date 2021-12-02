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

    private $depthLevel = 1;
    private $deepestLevel = 1;
    private $startingPoint;
    private $basePath = [];
    private $path = 1;
    private $paths = [];
    private $ignoredTargetPieces = [];

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
            $this->data->moveType = 'movePiece';
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
        if(!$this->startingPoint){
            $this->startingPoint = ['line' => $lSrc, 'column' => $cSrc];
        }

        for($i = 1 ; $i <= 4 ; $i++){
            if($i == 1){
                $lMidTmp = $this->startingPoint['line'] + 1;
                $cMidTmp = $this->startingPoint['column'] - 1;
                $lDstTmp = $this->startingPoint['line'] + 2;
                $cDstTmp = $this->startingPoint['column'] - 2;
            }
            elseif($i == 2){
                $lMidTmp = $this->startingPoint['line'] + 1;
                $cMidTmp = $this->startingPoint['column'] + 1;
                $lDstTmp = $this->startingPoint['line'] + 2;
                $cDstTmp = $this->startingPoint['column'] + 2;
            }
            elseif($i == 3){
                $lMidTmp = $this->startingPoint['line'] - 1;
                $cMidTmp = $this->startingPoint['column'] - 1;
                $lDstTmp = $this->startingPoint['line'] - 2;
                $cDstTmp = $this->startingPoint['column'] - 2;
            }
            elseif($i == 4){
                $lMidTmp = $this->startingPoint['line'] - 1;
                $cMidTmp = $this->startingPoint['column'] + 1;
                $lDstTmp = $this->startingPoint['line'] - 2;
                $cDstTmp = $this->startingPoint['column'] + 2;
            }

            if($this->checkLineColumn($lMidTmp, $cMidTmp) && $this->checkLineColumn($lDstTmp, $cDstTmp)){
                if($board->notEmpty($lMidTmp, $cMidTmp)){
                    $targetPiece = $board->getPiece($lMidTmp, $cMidTmp);

                    $ignoredTargetPieceId = 0;
                    for($n = 0 ; $n < count($this->ignoredTargetPieces) ; $n++){
                        $ignoredTargetPieceId = $this->ignoredTargetPieces[$n]->id;
                        if($targetPiece->id == $ignoredTargetPieceId){
                            break;
                        }
                    }

                    if($targetPiece->id != $ignoredTargetPieceId){
                        if($pAtt->color != $targetPiece->color && $board->isEmpty($lDstTmp, $cDstTmp)){

                            if($this->depthLevel < $this->deepestLevel){
                                $this->path++;
                                $this->paths[$this->path] = $this->basePath;
                            }

                            $this->basePath[] = $this->paths[$this->path][] = [
                                'source-line' => $this->startingPoint['line'],
                                'source-column' => $this->startingPoint['column'],
                                'middle-line' => $lMidTmp,
                                'middle-column' => $cMidTmp,
                                'destiny-line' => $lDstTmp,
                                'destiny-column' => $cDstTmp,
                                'target-piece' => $targetPiece
                            ];

                            $this->startingPoint = ['line' => $lDstTmp, 'column' => $cDstTmp];
                            $this->ignoredTargetPieces[] = $targetPiece;
                            $this->deepestLevel = ++$this->depthLevel;
                            $this->capture($board, $pAtt, $lSrc, $cSrc, $lDst, $cDst);
        
                            if($i == 1){
                                $this->startingPoint['line'] -= 2;
                                $this->startingPoint['column'] += 2;
                            }
                            elseif($i == 2){
                                $this->startingPoint['line'] -= 2;
                                $this->startingPoint['column'] -= 2;
                            }
                            elseif($i == 3){
                                $this->startingPoint['line'] += 2;
                                $this->startingPoint['column'] += 2;
                            }
                            elseif($i == 4){
                                $this->startingPoint['line'] += 2;
                                $this->startingPoint['column'] -= 2;
                            }
                            
                        }
                    }
                }
            }
        }

        array_pop($this->basePath);
        array_pop($this->ignoredTargetPieces);
        $this->depthLevel--;

        if(!$this->depthLevel && count($this->paths) > 0){
            if($this->checkPaths($lDst, $cDst)){
                return true;
            }
        }
    }

    private function checkPaths($lDst, $cDst){
        $pathsChecked = array_map('count', $this->paths);
        $bestPathKey = array_keys($pathsChecked , max($pathsChecked));

        if(count($bestPathKey) == 1){
            $bestPathKey = $bestPathKey[0];
            $targetPieces = $this->paths[$bestPathKey];
            $lastTargetPiece = end($targetPieces);

            if($lastTargetPiece['destiny-line'] == $lDst && $lastTargetPiece['destiny-column'] == $cDst){
                $this->data->moveType = 'capturePiece';
                $this->data->targetPieces = $targetPieces;
                return true;
            }
        }
        elseif(count($bestPathKey) > 1){
            for($i = 1; $i <= count($this->paths); $i++){
                $targetPieces = $this->paths[$i];
                $lastTargetPiece = end($targetPieces);

                if($lastTargetPiece['destiny-line'] == $lDst && $lastTargetPiece['destiny-column'] == $cDst){
                    $this->data->moveType = 'capturePiece';
                    $this->data->targetPieces = $targetPieces;
                    return true;
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
