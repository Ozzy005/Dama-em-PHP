<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Core\Data;

class Move
{
    public function make()
    {
        $data = Data::getInstance();
        list('board' => $b,'turn' => $turn,'movement-history' => $move_his,'cemetery' => $cemetery,'piece' => $p,'line-source' => $l_src,'column-source' => $c_src,'line-target' => $l_trt,'column-target' => $c_trt,'pieces-targets' => $ps_trts,'move-type' => $mt) = $data->getData();

        if($mt == 'movePiece')
        {
            $this->movePiece($data,$b,$turn,$move_his,$p,$l_src,$c_src,$l_trt,$c_trt);
        }
        elseif($mt == 'capturePiece')
        {
            $this->capturePiece($data,$b,$turn,$move_his,$cemetery,$p,$l_src,$c_src,$l_trt,$c_trt,$ps_trts);
        }
    }

    private function movePiece($data,$b,$turn,$move_his,$p,$l_src,$c_src,$l_trt,$c_trt)
    {
        $b->unsetPiece($l_src,$c_src);
        $b->setPiece($l_trt,$c_trt,$p);
        $move_his->setValues($turn,$p,$l_src,$c_src,$l_trt,$c_trt);
        $data->setValue('board',$b);
        $data->setValue('turn',++$turn);
        $data->setValue('movement-history',$move_his);
    }

    private function capturePiece($data,$b,$turn,$move_his,$cemetery,$p,$l_src,$c_src,$l_trt,$c_trt,$ps_trts)
    {
        $b->unsetPiece($l_src,$c_src);
        $b->setPiece($l_trt,$c_trt,$p);

        $cemetery[$turn] = [];

        for($n = 0 ; $n < count($ps_trts) ; $n++)
        {
            $p_trt = $ps_trts[$n]['piece-target'];
            $l_middle = $ps_trts[$n]['line-middle'];
            $c_middle = $ps_trts[$n]['column-middle'];

            $b->unsetPiece($l_middle,$c_middle);
            $cemetery[$turn][$n] = $p_trt;
        }

        $move_his->setValues($turn,$p,$l_src,$c_src,$l_trt,$c_trt,$ps_trts);

        $data->setValue('board',$b);
        $data->setValue('turn',++$turn);
        $data->setValue('movement-history',$move_his);
    }
}