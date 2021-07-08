<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function GerarTabuleiro($tabuleiro,$pecaEscolhida)
{
    $start_end = 1;
    $end_start = 12;

    foreach($tabuleiro as $keyLine => $valueLine)
    {
        foreach($valueLine as $keyCasa => $valueCasa)
        {
            $keyCasaExplode = explode('-',$keyCasa);

            if($pecaEscolhida === 'pretas')
            {
                if($keyCasaExplode[2] === 'preta' && $keyLine >= 1 && $keyLine <= 3)
                {
                    $tabuleiro[$keyLine][$keyCasa] = PECAS_PRETAS[$start_end];
                    $start_end++;
                }
                if($keyCasaExplode[2] === 'preta' && $keyLine >= 6 && $keyLine <= 8)
                {
                    $tabuleiro[$keyLine][$keyCasa] = PECAS_BRANCAS[$end_start];
                    $end_start--;
                }
            }
            if($pecaEscolhida === 'brancas')
            {
                if($keyCasaExplode[2] === 'preta' && $keyLine >= 1 && $keyLine <= 3)
                {
                    $tabuleiro[$keyLine][$keyCasa] = PECAS_BRANCAS[$start_end];
                    $start_end++;
                }
                if($keyCasaExplode[2] === 'preta' && $keyLine >= 6 && $keyLine <= 8)
                {
                    $tabuleiro[$keyLine][$keyCasa] = PECAS_PRETAS[$end_start];
                    $end_start--;
                }
            }
        }
    }
    return $tabuleiro;
}

?>