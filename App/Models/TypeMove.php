<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class TypeMove
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function check()
    {
        $data = $this->data;
        $board = $data->getValue('board');
        $l_src_id = $data->getValue('line-source')['id'];
        $l_trt_id = $data->getValue('line-target')['id'];
        $c_src_id = $data->getValue('column-source')['id'];
        $c_trt_id = $data->getValue('column-target')['id'];

        $code_c_src = ord($c_src_id);

        if( ($l_src_id + 1) === $l_trt_id xor ($l_src_id - 1) === $l_trt_id )
        {
            if( chr($code_c_src - 1) === $c_trt_id xor chr($code_c_src + 1) === $c_trt_id )
            {
                $data->setValue('move-type','movePiece');
            }
        }

        if( ($l_src_id + 2) === $l_trt_id xor ($l_src_id - 2) === $l_trt_id )
        {
            if( chr($code_c_src - 2) === $c_trt_id xor chr($code_c_src + 2) === $c_trt_id )
            {
                foreach($board as $key => $value)
                {
                    $key_parts = explode('-',$key);

                    if(($l_src_id + $l_trt_id) / 2 === (int)$key_parts[1])
                    {
                        $l_middle = $key; // linha do meio
                        $c_middle_id = chr( ( ord($c_src_id) + ord($c_trt_id) ) / 2); //id da coluna do meio

                        foreach($board[$l_middle] as $key => $value)
                        {
                            $key_parts = explode('-',$key);

                            if($key_parts[1] === $c_middle_id)
                            {
                                $c_middle = $key; // coluna do meio
                                $piece_trt = $value !== null ? $value : null; // peça alvo
                                break;
                            }
                        }
                        break;
                    }
                }

                $data->setValue('piece-target',$piece_trt);
                $data->setValue('line-middle',$l_middle);
                $data->setValue('column-middle',$c_middle);
                $data->setValue('move-type','capturePiece');
            }
        }
    }
}