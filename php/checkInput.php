<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function checkInput($casa,$peca)
{
    //tratamento de valores inválidos recebidos via input do formulário
    $casaExplode = explode('-',$casa);
    $pecaExplode = explode('-',$peca);

    if(count($pecaExplode) == 3)
    {
        $pecaPosUm = ($pecaExplode[0] == 'peca') ? true : false;
        $pecaPosDois = ($pecaExplode[1] == 'branca' || $pecaExplode[1] == 'preta') ? true : false;
        $pecaPosTres = ($pecaExplode[2] >= 1 && $pecaExplode[2] <=12) ? true : false;

        $pecaVerified = ($pecaPosUm == true && $pecaPosDois == true && $pecaPosTres == true) ? true : false;
    }

    if(count($casaExplode) == 3)
    {
        $casaPosUm = ($casaExplode[0] == 'casa') ? true : false;
        $caractere = (strlen($casaExplode[1]) == 2) ? substr($casaExplode[1],0,-1) : false;
        $casaPosDois = ($caractere >=1 && $caractere <= 8) ? true : false;
        $casaPosTres= ($casaExplode[2] == 'branca' || $casaExplode[2] == 'preta') ? true : false;

        $casaCheck = ($casaPosUm == true && $casaPosDois == true && $casaPosTres == true) ? true : false;

        if($casaCheck == true)
        {
            $casaVerified = true;
            $casaPosition[0] = $caractere;
            $casaPosition[1] = $casa;
            $casaPosition[2] = $casaExplode[2];
        }
    }
    return (@$casaVerified == true && @$pecaVerified == true) ? $casaPosition : false;
    //final do tratamento dos valores inválidos
}
?>