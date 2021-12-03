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

    private $nivelDeProfundidade = 1;
    private $nivelMaximoDeProfundidade = 1;
    private $pontoDePartida;
    private $trajetoBase = [];
    private $opcao = 1;
    private $opcoesInternasMapeadas = [];
    private $pecasAlvosIgnoradas = [];

    public function check(){
        try{
            $this->turnoDeQuem();
            $opcoesExternasMapeadas = $this->mapearOpcoesDeCapturasExternas();
            if($opcoesExternasMapeadas){
                if($this->aplicarLeiDaMaioria($opcoesExternasMapeadas)){
                    return true;
                }
                throw new Exception('Movimento Inválido');
            }
            if($this->movimento()){return true;}
            else{throw new Exception('Movimento Inválido');}
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function turnoDeQuem(){
        $historicoDeMovimento = $this->data->movementHistory;
        $pAtacante = $this->data->pieceAttacking;
        $ultimoMovimento = $historicoDeMovimento->getLastMove();

        if($ultimoMovimento && $ultimoMovimento['piece-attacking']->color == $pAtacante->color){
            throw new Exception('Não é sua vez de jogar');
        }
        elseif(!$ultimoMovimento && $pAtacante->isBlack()){
            throw new Exception('O lance inicial cabe ao jogador que estiver com as peças brancas');
        }
    }

    private function movimento(){
        $corEscolhida = $this->data->playerChosen;
        $tabuleiro = $this->data->board;
        $pAtacante = $this->data->pieceAttacking;
        $lOrigem = $this->data->lineSource;
        $cOrigem = $this->data->columnSource;
        $lDestino = $this->data->lineDestiny;
        $cDestino = $this->data->columnDestiny;

        for($n = 1 ; $n <= 4 ; $n++){
            if($n == 1){
                $l = $lOrigem + 1;
                $c = $cOrigem - 1;
            }
            elseif($n == 2){
                $l = $lOrigem + 1;
                $c = $cOrigem + 1;
            }
            elseif($n == 3){
                $l = $lOrigem - 1;
                $c = $cOrigem - 1;
            }
            elseif($n == 4){
                $l = $lOrigem - 1;
                $c = $cOrigem + 1;
            }

            if($this->checarLimitesDaMargemDoTabuleiro($l, $c) && $tabuleiro->isEmpty($l, $c) && $l == $lDestino && $c == $cDestino){
                if($corEscolhida == 1){
                    if($pAtacante->isWhite() && $lOrigem < $lDestino){
                        $this->data->moveType = 'mover';
                        return true;
                    }
                    elseif($pAtacante->isBlack() && $lOrigem > $lDestino){
                        $this->data->moveType = 'mover';
                        return true;
                    }
                }
                elseif($corEscolhida == 2){
                    if($pAtacante->isBlack() && $lOrigem < $lDestino){
                        $this->data->moveType = 'mover';
                        return true;
                    }
                    elseif($pAtacante->isWhite() && $lOrigem > $lDestino){
                        $this->data->moveType = 'mover';
                        return true;
                    }
                }
            }
        }
    }

    private function mapearOpcoesDeCapturasInternas($pAtacante, $lOrigem = null, $cOrigem = null){
        $tabuleiro = $this->data->board;

        if(!$this->pontoDePartida && $lOrigem && $cOrigem){
            $this->pontoDePartida = ['linha' => $lOrigem, 'coluna' => $cOrigem];
        }

        for($i = 1 ; $i <= 4 ; $i++){
            if($i == 1){
                $lMeioTmp = $this->pontoDePartida['linha'] + 1;
                $cMeioTmp = $this->pontoDePartida['coluna'] - 1;
                $lDestinoTmp = $this->pontoDePartida['linha'] + 2;
                $cDestinoTmp = $this->pontoDePartida['coluna'] - 2;
            }
            elseif($i == 2){
                $lMeioTmp = $this->pontoDePartida['linha'] + 1;
                $cMeioTmp = $this->pontoDePartida['coluna'] + 1;
                $lDestinoTmp = $this->pontoDePartida['linha'] + 2;
                $cDestinoTmp = $this->pontoDePartida['coluna'] + 2;
            }
            elseif($i == 3){
                $lMeioTmp = $this->pontoDePartida['linha'] - 1;
                $cMeioTmp = $this->pontoDePartida['coluna'] - 1;
                $lDestinoTmp = $this->pontoDePartida['linha'] - 2;
                $cDestinoTmp = $this->pontoDePartida['coluna'] - 2;
            }
            elseif($i == 4){
                $lMeioTmp = $this->pontoDePartida['linha'] - 1;
                $cMeioTmp = $this->pontoDePartida['coluna'] + 1;
                $lDestinoTmp = $this->pontoDePartida['linha'] - 2;
                $cDestinoTmp = $this->pontoDePartida['coluna'] + 2;
            }

            if($this->checarLimitesDaMargemDoTabuleiro($lMeioTmp, $cMeioTmp) &&
               $this->checarLimitesDaMargemDoTabuleiro($lDestinoTmp, $cDestinoTmp)){
                if($tabuleiro->notEmpty($lMeioTmp, $cMeioTmp)){
                    $pecaAlvo = $tabuleiro->getPiece($lMeioTmp, $cMeioTmp);

                    $pecaAlvoIgnoradaId = 0;
                    for($n = 0 ; $n < count($this->pecasAlvosIgnoradas) ; $n++){
                        $pecaAlvoIgnoradaId = $this->pecasAlvosIgnoradas[$n]->id;
                        if($pecaAlvo->id == $pecaAlvoIgnoradaId){
                            break;
                        }
                    }

                    if($pecaAlvo->id != $pecaAlvoIgnoradaId){
                        if($pAtacante->color != $pecaAlvo->color && $tabuleiro->isEmpty($lDestinoTmp, $cDestinoTmp)){

                            if($this->nivelDeProfundidade < $this->nivelMaximoDeProfundidade){
                                $this->opcao++;
                                $this->opcoesInternasMapeadas[$this->opcao] = $this->trajetoBase;
                            }

                            $this->trajetoBase[] = $this->opcoesInternasMapeadas[$this->opcao][] = [
                                'linhaOrigem' => $this->pontoDePartida['linha'],
                                'ColunaOrigem' => $this->pontoDePartida['coluna'],
                                'linhaDoMeio' => $lMeioTmp,
                                'colunaDoMeio' => $cMeioTmp,
                                'linhaDestino' => $lDestinoTmp,
                                'colunaDestino' => $cDestinoTmp,
                                'pecaAlvo' => $pecaAlvo,
                                'pecaAtacante' => $pAtacante
                            ];

                            $tabuleiro->unsetPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna']);
                            $tabuleiro->setPiece($lDestinoTmp, $cDestinoTmp, $pAtacante);
                            $this->pontoDePartida = ['linha' => $lDestinoTmp, 'coluna' => $cDestinoTmp];
                            $this->pecasAlvosIgnoradas[] = $pecaAlvo;
                            $this->nivelMaximoDeProfundidade = ++$this->nivelDeProfundidade;
                            $this->mapearOpcoesDeCapturasInternas($pAtacante);
        
                            if($i == 1){
                                $tabuleiro->unsetPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna']);
                                $this->pontoDePartida['linha'] -= 2;
                                $this->pontoDePartida['coluna'] += 2;
                                $tabuleiro->setPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna'], $pAtacante);
                            }
                            elseif($i == 2){
                                $tabuleiro->unsetPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna']);
                                $this->pontoDePartida['linha'] -= 2;
                                $this->pontoDePartida['coluna'] -= 2;
                                $tabuleiro->setPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna'], $pAtacante);
                            }
                            elseif($i == 3){
                                $tabuleiro->unsetPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna']);
                                $this->pontoDePartida['linha'] += 2;
                                $this->pontoDePartida['coluna'] += 2;
                                $tabuleiro->setPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna'], $pAtacante);
                            }
                            elseif($i == 4){
                                $tabuleiro->unsetPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna']);
                                $this->pontoDePartida['linha'] += 2;
                                $this->pontoDePartida['coluna'] -= 2;
                                $tabuleiro->setPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna'], $pAtacante);
                            }
                        }
                    }
                }
            }
        }

        array_pop($this->trajetoBase);
        array_pop($this->pecasAlvosIgnoradas);
        $this->nivelDeProfundidade--;

        if(!$this->nivelDeProfundidade && count($this->opcoesInternasMapeadas)){
            $opcoesContadas = array_map('count', $this->opcoesInternasMapeadas);
            $melhorOpcao = array_keys($opcoesContadas , max($opcoesContadas));

            $retorno = [];
            foreach($melhorOpcao as $value){
                $retorno[$value] = $this->opcoesInternasMapeadas[$value];
            }

            return $retorno;
        }
    }

    private function aplicarLeiDaMaioria($opcoesMapeadas){
        $pAtacante = $this->data->pieceAttacking;
        $lDestino = $this->data->lineDestiny;
        $cDestino = $this->data->columnDestiny;

        $opcoesContadas = array_map('count', $opcoesMapeadas);
        $chaveDasMelhoresOpcoes = array_keys($opcoesContadas , max($opcoesContadas));

        if(count($chaveDasMelhoresOpcoes) == 1){
            $chaveDaMelhorOpcao = $chaveDasMelhoresOpcoes[0];
            $pecasAlvos = $opcoesMapeadas[$chaveDaMelhorOpcao];
            $ultimaPecaAlvo = end($pecasAlvos);

            if($ultimaPecaAlvo['linhaDestino'] == $lDestino && $ultimaPecaAlvo['colunaDestino'] == $cDestino){
                $this->data->moveType = 'capturar';
                $this->data->targetPieces = $pecasAlvos;
                return true;
            }
        }
        elseif(count($chaveDasMelhoresOpcoes) > 1){
            for($i = 0; $i < count($chaveDasMelhoresOpcoes); $i++){
                $chaveDaMelhorOpcao = $chaveDasMelhoresOpcoes[$i];
                $pecasAlvos = $opcoesMapeadas[$chaveDaMelhorOpcao];
                $ultimaPecaAlvo = end($pecasAlvos);

                if($ultimaPecaAlvo['pecaAtacante']->id == $pAtacante->id &&
                   $ultimaPecaAlvo['linhaDestino'] == $lDestino && $ultimaPecaAlvo['colunaDestino'] == $cDestino){
                    $this->data->moveType = 'capturar';
                    $this->data->targetPieces = $pecasAlvos;
                    return true;
                }
            }
        }
    }

    private function mapearOpcoesDeCapturasExternas(){
        $tabuleiro = $this->data->board;
        $pAtacante = $this->data->pieceAttacking;
        $opcoesExternasMapeadas = [];

        foreach($tabuleiro->getBoard() as $chaveDaLinha => $linha){
            foreach($linha as $coluna => $peca){
                if($tabuleiro->isBlack($chaveDaLinha, $coluna) && $peca && $peca->color == $pAtacante->color){
                    $melhorOpcaoInterna = $this->mapearOpcoesDeCapturasInternas($peca, $chaveDaLinha, $coluna);

                    if($melhorOpcaoInterna){
                        $opcoesExternasMapeadas = array_merge($opcoesExternasMapeadas, $melhorOpcaoInterna);
                    }
                    $this->nivelDeProfundidade = $this->nivelMaximoDeProfundidade = $this->opcao = 1;
                    $this->pontoDePartida = $this->pecasAlvosIgnoradas = $this->trajetoBase = $this->opcoesInternasMapeadas = [];
                }
            }
        }

        if(count($opcoesExternasMapeadas)){
            return $opcoesExternasMapeadas;
        }
    }

    private function checarLimitesDaMargemDoTabuleiro($l, $c){
        if($l >= 1 && $l <= 8 && $c >= 97 && $c <= 104){
            return true;
        }
    }
}
