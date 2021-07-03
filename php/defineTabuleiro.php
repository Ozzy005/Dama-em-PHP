<?php

/**
 *
 * @author Rafael Arend
 *
 **/

//Criação do tabuleiro
function defineTabuleiro($peca_escolhida)
{
    $TABULEIRO = [
        1 => [
            'CASA-1A-BRANCA' => NULL,
            'CASA-1B-PRETA' => NULL,
            'CASA-1C-BRANCA' => NULL,
            'CASA-1D-PRETA' => NULL,
            'CASA-1E-BRANCA' => NULL,
            'CASA-1F-PRETA' => NULL,
            'CASA-1G-BRANCA' => NULL,
            'CASA-1H-PRETA' => NULL
        ],
        2 => [
            'CASA-2A-PRETA' => NULL,
            'CASA-2B-BRANCA' => NULL,
            'CASA-2C-PRETA' => NULL,
            'CASA-2D-BRANCA' => NULL,
            'CASA-2E-PRETA' => NULL,
            'CASA-2F-BRANCA' => NULL,
            'CASA-2G-PRETA' => NULL,
            'CASA-2H-BRANCA' => NULL
        ],
        3 => [
            'CASA-3A-BRANCA' => NULL,
            'CASA-3B-PRETA' => NULL,
            'CASA-3C-BRANCA' => NULL,
            'CASA-3D-PRETA' => NULL,
            'CASA-3E-BRANCA' => NULL,
            'CASA-3F-PRETA' => NULL,
            'CASA-3G-BRANCA' => NULL,
            'CASA-3H-PRETA' => NULL
        ],
        4 => [
            'CASA-4A-PRETA' => NULL,
            'CASA-4B-BRANCA' => NULL,
            'CASA-4C-PRETA' => NULL,
            'CASA-4D-BRANCA' => NULL,
            'CASA-4E-PRETA' => NULL,
            'CASA-4F-BRANCA' => NULL,
            'CASA-4G-PRETA' => NULL,
            'CASA-4H-BRANCA' => NULL
        ],
        5 => [
            'CASA-5A-BRANCA' => NULL,
            'CASA-5B-PRETA' => NULL,
            'CASA-5C-BRANCA' => NULL,
            'CASA-5D-PRETA' => NULL,
            'CASA-5E-BRANCA' => NULL,
            'CASA-5F-PRETA' => NULL,
            'CASA-5G-BRANCA' => NULL,
            'CASA-5H-PRETA' => NULL
        ],
        6 => [
            'CASA-6A-PRETA' => NULL,
            'CASA-6B-BRANCA' => NULL,
            'CASA-6C-PRETA' => NULL,
            'CASA-6D-BRANCA' => NULL,
            'CASA-6E-PRETA' => NULL,
            'CASA-6F-BRANCA' => NULL,
            'CASA-6G-PRETA' => NULL,
            'CASA-6H-BRANCA' => NULL
        ],
        7 => [
            'CASA-7A-BRANCA' => NULL,
            'CASA-7B-PRETA' => NULL,
            'CASA-7C-BRANCA' => NULL,
            'CASA-7D-PRETA' => NULL,
            'CASA-7E-BRANCA' => NULL,
            'CASA-7F-PRETA' => NULL,
            'CASA-7G-BRANCA' => NULL,
            'CASA-7H-PRETA' => NULL
        ],
        8 => [
            'CASA-8A-PRETA' => NULL,
            'CASA-8B-BRANCA' => NULL,
            'CASA-8C-PRETA' => NULL,
            'CASA-8D-BRANCA' => NULL,
            'CASA-8E-PRETA' => NULL,
            'CASA-8F-BRANCA' => NULL,
            'CASA-8G-PRETA' => NULL,
            'CASA-8H-BRANCA' => NULL
        ]
    ];


    //Organiza as peças no tabuleiro de acordo com a cor das peças escolhidas na página inicial
    $start_end = 1;
    $end_start = 12;

    foreach($TABULEIRO as $linekey => $linevalue)
    {
        foreach($linevalue as $casakey => $casavalue)
        {
            $casacor = explode('-',$casakey);

            if($peca_escolhida == 'PRETAS')
            {
                if($casacor[2] == 'PRETA' && $linekey >= 1 && $linekey <= 3)
                {
                    $TABULEIRO[$linekey][$casakey] = PECAS_PRETAS[$start_end];
                    $start_end++;
                }
                if($casacor[2] == 'PRETA' && $linekey >= 6 && $linekey <= 8)
                {
                    $TABULEIRO[$linekey][$casakey] = PECAS_BRANCAS[$end_start];
                    $end_start--;
                }
            }
            if($peca_escolhida == 'BRANCAS')
            {
                if($casacor[2] == 'PRETA' && $linekey >= 1 && $linekey <= 3)
                {
                    $TABULEIRO[$linekey][$casakey] = PECAS_BRANCAS[$start_end];
                    $start_end++;
                }
                if($casacor[2] == 'PRETA' && $linekey >= 6 && $linekey <= 8)
                {
                    $TABULEIRO[$linekey][$casakey] = PECAS_PRETAS[$end_start];
                    $end_start--;
                }
            }
        }
    }
    return $TABULEIRO;
}
?>