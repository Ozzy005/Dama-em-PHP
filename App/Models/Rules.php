<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Core\Data;
use Exception;

class Rules
{
    private $options = [];
    private $p_catchable = [];
    private $depth_level = 0;

    public function check()
    {
        $data = Data::getInstance();
        ['color-chosen' => $player, 'board' => $board, 'piece' => $p_att, 'line-source' => $l_src, 'column-source' => $c_src, 'line-target' => $l_dst, 'column-target' => $c_dst] = $data->getData();
        if($this->movement($data,$player,$board,$p_att,$l_src,$c_src,$l_dst,$c_dst)){return true;}
        if($this->capture($data,$board,$p_att,$l_src,$c_src,$l_dst,$c_dst)){return true;}
        else{throw new Exception('Movimento Inválido');}
    }

    // verifica se a peça está movendo-se pra coluna, linha e direção correta
    // verifica se a peça não está movendo-se pra uma casa ocupada
    private function movement($data,$player,$board,$p_att,$l_src,$c_src,$l_dst,$c_dst)
    {
        for($n = 1 ; $n <= 4 ; $n++)
        {
            if($n == 1){$l = $l_src + 1; $c = $c_src - 1;} //coluna superior esquerda
            elseif($n == 2){$l = $l_src + 1; $c = $c_src + 1;} //coluna superior direita
            elseif($n == 3){$l = $l_src - 1; $c = $c_src - 1;} //coluna inferior esquerda
            elseif($n == 4){$l = $l_src - 1; $c = $c_src + 1;} //coluna inferior direita

            if($l >= 1 && $l <= 8 && $c >= 97 && $c <= 104 && $board->isEmpty($l,$c) && $l == $l_dst && $c == $c_dst)
            {
                if($player == 1)
                {
                    if($p_att->isWhite() && $l_src < $l_dst)
                    {
                        $data->setValue('move-type','movePiece');
                        return true;
                    }
                    elseif($p_att->isBlack() && $l_src > $l_dst)
                    {
                        $data->setValue('move-type','movePiece');
                        return true;
                    }
                }
                elseif($player == 2)
                {
                    if($p_att->isBlack() && $l_src < $l_dst)
                    {
                        $data->setValue('move-type','movePiece');
                        return true;
                    }
                    elseif($p_att->isWhite() && $l_src > $l_dst)
                    {
                        $data->setValue('move-type','movePiece');
                        return true;
                    }
                }
            }
        }
    }

    // obs: ainda não terminado, mas quase =D
    // 1 verifica todas as possibilidades de captura
    // 2 compara as possibilidade, verificando qual captura o maior numero possível de peças
    // 3 se a casa de destino corresponder a possibilidade que capture o maior numero possível de peças então faz o movimento de multiplas capturas
    // 3 se houver duas possibilidades ou mais igualmente benéficas que leva a mesma casa de destino então opta por uma possibilidade aleatória
    private function capture($data,$board,$p_att,$l_src,$c_src,$l_dst,$c_dst, $pos = [])
    {
        $this->depth_level++;

        for($n = 1 ; $n <= 4 ; $n++)
        {
            if($n == 1) //coluna superior esquerda
            {
                $side = 'cse';
                $l1 = $l_src + 1; $c1 = $c_src - 1;
                $l2 = $l_src + 2; $c2 = $c_src - 2;
            }
            elseif($n == 2) //coluna superior direita
            {
                $side = 'csd';
                $l1 = $l_src + 1; $c1 = $c_src + 1;
                $l2 = $l_src + 2; $c2 = $c_src + 2;
            }
            elseif($n == 3) //coluna inferior esquerda
            {
                $side = 'cie';
                $l1 = $l_src - 1; $c1 = $c_src - 1;
                $l2 = $l_src - 2; $c2 = $c_src - 2;
            }
            elseif($n == 4) //coluna inferior direita
            {
                $side = 'cid';
                $l1 = $l_src - 1; $c1 = $c_src + 1;
                $l2 = $l_src - 2; $c2 = $c_src + 2;
            }

            if($l1 >= 1 && $l1 <= 8 && $c1 >= 97 && $c1 <= 104 && $l2 >= 1 && $l2 <= 8 && $c2 >= 97 && $c2 <= 104)
            {
                if($board->notEmpty($l1,$c1) && $board->getPiece($l1,$c1)->getColor() != $p_att->getColor())
                {
                    $p_catchable_id = 0;
                    $p_enemy = $board->getPiece($l1,$c1);

                    for ($i = 0; $i < count($this->p_catchable); $i++)
                    {
                        $p_catchable_id = $this->p_catchable[$i];

                        if($p_enemy->getId() == $p_catchable_id){break;}
                    }

                    if($p_enemy->getId() != $p_catchable_id)
                    {
                        if($this->depth_level == 1)
                        {
                            $this->p_catchable[] = $p_enemy->getId();
                            $this->options[$n] = [];
                            $pos[] = $n;
                        }
                        if($this->depth_level == 2)
                        {
                            $this->p_catchable[] = $p_enemy->getId();
                            $this->options[$pos[0]][$n] = [];
                            $pos[] = $n;
                        }
                        if($this->depth_level == 3)
                        {
                            $this->p_catchable[] = $p_enemy->getId();
                            $this->options[$pos[0]][$pos[1]][$n] = [];
                            $pos[] = $n;
                        }
                        if($this->depth_level == 4)
                        {
                            $this->p_catchable[] = $p_enemy->getId();
                            $this->options[$pos[0]][$pos[1]][$pos[2]][$n] = [];
                            $pos[] = $n;
                        }
                        if($this->depth_level == 5)
                        {
                            $this->p_catchable[] = $p_enemy->getId();
                            $this->options[$pos[0]][$pos[1]][$pos[2]][$pos[3]][$n] = [];
                            $pos[] = $n;
                        }
                        if($this->depth_level == 6)
                        {
                            $this->p_catchable[] = $p_enemy->getId();
                            $this->options[$pos[0]][$pos[1]][$pos[2]][$pos[3]][$pos[4]][$n] = [];
                            $pos[] = $n;
                        }
                        if($this->depth_level == 7)
                        {
                            $this->p_catchable[] = $p_enemy->getId();
                            $this->options[$pos[0]][$pos[1]][$pos[2]][$pos[3]][$pos[4]][$pos[5]][$n] = [];
                            $pos[] = $n;
                        }

                        $l_src = $l2; $c_src = $c2;

                        $this->capture($data,$board,$p_att,$l_src,$c_src,$l_dst,$c_dst,$pos);

                        if($side == 'cse'){$l_src -= 2; $c_src += 2;}
                        elseif($side == 'csd'){$l_src -= 2; $c_src -= 2;}
                        elseif($side == 'cie'){$l_src += 2; $c_src += 2;}
                        if($side == 'cid'){$l_src += 2; $c_src -= 2;}

                        array_pop($pos);
                    }
                }
            }
        }
        array_pop($this->p_catchable);
        $this->depth_level--;
    }
}

