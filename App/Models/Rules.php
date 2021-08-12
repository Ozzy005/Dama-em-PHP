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
    private $path = [];
    private $path_base = [];
    private $ignored = [];
    private $option = 1;
    private $depth_level = 0;
    private $depth_level_max = 0;

    public function check()
    {
        $data = Data::getInstance();
        ['player-chosen' => $p_chosen, 'board' => $board, 'piece-attacking' => $p_att, 'line-source' => $l_src, 'column-source' => $c_src, 'line-destiny' => $l_dst, 'column-destiny' => $c_dst] = $data->getData();
        //$data->setValue('move-type','movePiece');
        if($this->movement($data ,$p_chosen, $board, $p_att, $l_src, $c_src, $l_dst, $c_dst)){return true;}
        if($this->capture($data, $board, $p_att, $l_src, $c_src, $l_dst, $c_dst)){return true;}
        else{throw new Exception('Movimento Inválido');}
    }

    private function movement($data, $p_chosen, $board, $p_att, $l_src, $c_src, $l_dst, $c_dst)
    {
        for($n = 1 ; $n <= 4 ; $n++)
        {
            if($n == 1){$l = $l_src + 1; $c = $c_src - 1;}
            elseif($n == 2){$l = $l_src + 1; $c = $c_src + 1;}
            elseif($n == 3){$l = $l_src - 1; $c = $c_src - 1;}
            elseif($n == 4){$l = $l_src - 1; $c = $c_src + 1;}

            if($l >= 1 && $l <= 8 && $c >= 97 && $c <= 104 && $board->isEmpty($l,$c) && $l == $l_dst && $c == $c_dst)
            {
                if($p_chosen == 1)
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
                elseif($p_chosen == 2)
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

    private function capture($data, $board, $p_att, $l_src, $c_src, $l_dst, $c_dst)
    {
        for($n = 1 ; $n <= 4 ; $n++)
        {
            if($n == 1){$side = 'cse'; $l1 = $l_src + 1; $c1 = $c_src - 1; $l2 = $l_src + 2; $c2 = $c_src - 2;}
            elseif($n == 2){$side = 'csd'; $l1 = $l_src + 1; $c1 = $c_src + 1; $l2 = $l_src + 2; $c2 = $c_src + 2;}
            elseif($n == 3){$side = 'cie'; $l1 = $l_src - 1; $c1 = $c_src - 1; $l2 = $l_src - 2; $c2 = $c_src - 2;}
            elseif($n == 4){$side = 'cid'; $l1 = $l_src - 1; $c1 = $c_src + 1; $l2 = $l_src - 2; $c2 = $c_src + 2;}

            if($l1 >= 1 && $l1 <= 8 && $c1 >= 97 && $c1 <= 104 && $l2 >= 1 && $l2 <= 8 && $c2 >= 97 && $c2 <= 104)
            {
                if($board->notEmpty($l1, $c1) && $board->isEmpty($l2, $c2) && $board->getPiece($l1, $c1)->getColor() != $p_att->getColor())
                {
                    $ignored_id = 0;
                    $p_enemy = $board->getPiece($l1, $c1);

                    for ($i = 0; $i < count($this->ignored); $i++)
                    {
                        $ignored_id = $this->ignored[$i]->getId();

                        if($p_enemy->getId() == $ignored_id){break;}
                    }

                    if($p_enemy->getId() != $ignored_id)
                    {
                        if($this->depth_level < $this->depth_level_max)
                        {
                            $this->option++;
                            $this->path[$this->option] = array_merge($this->path_base);
                        }

                        $this->depth_level_max = ++$this->depth_level;
                        $this->ignored[] = $p_enemy;
                        $this->path_base[] = $this->path[$this->option][] = ['l-src' => $l_src, 'c-src' => $c_src, 'p-enemy' => $p_enemy, 'l-mdw' => $l1, 'c-mdw' => $c1, 'l-dst' => $l2, 'c-dst' => $c2];
                        $l_src = $l2; $c_src = $c2;

                        $this->capture($data, $board, $p_att, $l_src, $c_src, $l_dst, $c_dst);

                        if($side == 'cse'){$l_src -= 2; $c_src += 2;}
                        elseif($side == 'csd'){$l_src -= 2; $c_src -= 2;}
                        elseif($side == 'cie'){$l_src += 2; $c_src += 2;}
                        elseif($side == 'cid'){$l_src += 2; $c_src -= 2;}
                    }
                }
            }
        }

        array_pop($this->path_base);
        array_pop($this->ignored);
        $this->depth_level--;

        if($this->depth_level == -1 && count($this->path) > 0)
        {
            $count = array_map('count', $this->path);
            $max = array_keys($count , max($count))[0];
            $key = array_key_last($this->path[$max]);

            if($this->path[$max][$key]['l-dst'] == $l_dst && $this->path[$max][$key]['c-dst'] == $c_dst)
            {
                $data->setValue('move-type','capturePiece');
                $pieces_captured = [];

                foreach($this->path[$max] as $value)
                {
                    $pieces_captured[] =
                    [
                        'piece-captured' => $value['p-enemy'],
                        'line-midway' => $value['l-mdw'],
                        'column-midway' => $value['c-mdw']
                    ];
                }

                $data->setValue('pieces-captured',$pieces_captured);
                return true;
            }
        }
    }
}

