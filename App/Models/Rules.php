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
    private $data,$board,$p_current,$l_src,$c_src,$l_trt,$c_trt;
    private $neighbors = [];
    private $pieces_targets = [];
    private $pos_check = [];
    private $loop = true;

    public function __construct()
    {
        $this->data = Data::getInstance();
        list('board' => $this->board, 'piece' => $this->p_current, 'line-source' => $this->l_src, 'column-source' => $this->c_src, 'line-target' => $this->l_trt, 'column-target' => $this->c_trt) = $this->data->getData();
    }

    public function check()
    {
        if($this->movement()){return true;}
        elseif($this->capture()){return true;}
        elseif($this->multipleCapture()){return true;}
        else{throw new Exception('Jogada inválida');}
    }

    private function movement($type = 0, $i = 0)
    {
        if($i < count($this->pos_check))
        {
            $this->l_src = $this->pos_check[$i]['line-source'];
            $this->c_src = $this->pos_check[$i]['column-source'];
        }

        for($n = 1 ; $n <= 4 ; $n++)
        {
            switch($n)
            {
                case 1: $l = $this->l_src+1; $c = $this->c_src-1; $side = 'cse'; break; //coluna superior esquerda
                case 2: $l = $this->l_src+1; $c = $this->c_src+1; $side = 'csd'; break; //coluna superior direita
                case 3: $l = $this->l_src-1; $c = $this->c_src-1; $side = 'cie'; break; //coluna inferior esquerda
                case 4: $l = $this->l_src-1; $c = $this->c_src+1; $side = 'cid'; break; //coluna inferior direita
            }

            if($l >= 1 && $l <= 8 && $c >= 97 && $c <= 104)
            {
                switch($type)
                {
                    case 0:
                        if($this->board->isEmpty($l,$c) && $l == $this->l_trt && $c == $this->c_trt)
                        {
                            $this->data->setValue('move-type','movePiece');
                            return true;
                        }
                        break;
                    case 1:
                        if($this->board->notEmpty($l,$c))
                        {
                            $p_last_id = 0;
                            $p_trt = $this->board->getPiece($l,$c);

                            for($j = 0 ; $j < count($this->pieces_targets); $j++)
                            {
                                $p_last_id = $this->pieces_targets[$j]['piece-target']->getId();
                                if($p_trt->getId() == $p_last_id){break;}
                            }

                            if($this->p_current->getColor() != $p_trt->getColor() && $p_trt->getId() != $p_last_id)
                            {
                                $this->neighbors[] = ['side' => $side,'p-trt' => $p_trt,'l-middle' => $l,'c-middle' => $c];
                            }
                        }
                        break;
                }
            }
        }

        $i++;

        if($i < count($this->pos_check))
        {
            $this->movement(1,$i);
        }
    }

    private function capture($type = 0)
    {
        $this->movement(1);

        $this->pos_check = [];

        for($n = 0 ; $n < count($this->neighbors) ; $n++)
        {
            $side = $this->neighbors[$n]['side'];
            $p_trt = $this->neighbors[$n]['p-trt'];
            $l_middle = $this->neighbors[$n]['l-middle'];
            $c_middle = $this->neighbors[$n]['c-middle'];

            switch($side)
            {
                case 'cse': $l = $l_middle+1; $c = $c_middle-1; break; //coluna superior esquerda
                case 'csd': $l = $l_middle+1; $c = $c_middle+1; break; //coluna superior direita
                case 'cie': $l = $l_middle-1; $c = $c_middle-1; break; //coluna inferior esquerda
                case 'cid': $l = $l_middle-1; $c = $c_middle+1; break; //coluna inferior direita
            }

            if($l >= 1 && $l <= 8 && $c >= 97 && $c <= 104)
            {
                switch($type)
                {
                    case 0:
                        if($this->board->isEmpty($l,$c) && $l == $this->l_trt && $c == $this->c_trt)
                        {
                            $this->data->setValue('move-type','capturePiece');
                            $this->data->setValue('pieces-targets', [['piece-target' => $p_trt,'line-middle' => $l_middle,'column-middle' => $c_middle]]);

                            return true;
                        }
                        break;
                    case 1:
                        if($this->board->isEmpty($l,$c) && ($l != $this->l_trt || $c != $this->c_trt))
                        {
                            $this->pos_check[] = ['line-source' => $l,'column-source' => $c];
                            $this->pieces_targets[] = ['piece-target' => $p_trt,'line-middle' => $l_middle,'column-middle' => $c_middle];
                        }
                        elseif($this->board->isEmpty($l,$c) && $l == $this->l_trt && $c == $this->c_trt)
                        {
                            $this->loop = false;
                            $this->pieces_targets[] = ['piece-target' => $p_trt,'line-middle' => $l_middle,'column-middle' => $c_middle];

                            return true;
                        }
                        break;
                 }
            }
        }
    }

    private function multipleCapture()
    {
        do
        {
            $old = count($this->pieces_targets);
            $this->neighbors = [];

            if($this->capture(1))
            {
                $this->data->setValue('move-type','capturePiece');
                $this->data->setValue('pieces-targets', $this->pieces_targets);
                return true;
            }
        }
        while($this->loop xor $old === count($this->pieces_targets));
    }
}