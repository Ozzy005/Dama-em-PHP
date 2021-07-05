<?php

/**
 *
 * @author Rafael Arend
 *
 **/

//Organiza as peças no tabuleiro de acordo com a cor das peças escolhidas na página inicial
function organizaTabuleiro($tabuleiro,$peca_escolhida)
{
    $start_end = 1;
    $end_start = 12;

    foreach($tabuleiro as $linekey => $linevalue)
    {
        foreach($linevalue as $casakey => $casavalue)
        {
            $casacor = explode('-',$casakey);

            if($peca_escolhida == 'pretas')
            {
                if($casacor[2] == 'preta' && $linekey >= 1 && $linekey <= 3)
                {
                    $tabuleiro[$linekey][$casakey] = PECAS_PRETAS[$start_end];
                    $start_end++;
                }
                if($casacor[2] == 'preta' && $linekey >= 6 && $linekey <= 8)
                {
                    $tabuleiro[$linekey][$casakey] = PECAS_BRANCAS[$end_start];
                    $end_start--;
                }
            }
            if($peca_escolhida == 'brancas')
            {
                if($casacor[2] == 'preta' && $linekey >= 1 && $linekey <= 3)
                {
                    $tabuleiro[$linekey][$casakey] = PECAS_BRANCAS[$start_end];
                    $start_end++;
                }
                if($casacor[2] == 'preta' && $linekey >= 6 && $linekey <= 8)
                {
                    $tabuleiro[$linekey][$casakey] = PECAS_PRETAS[$end_start];
                    $end_start--;
                }
            }
        }
    }
    return $tabuleiro;
}

?>