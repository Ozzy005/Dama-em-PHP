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

        $pecaCheck = ($pecaPosUm == true && $pecaPosDois == true && $pecaPosTres == true) ? true : false;

        if($pecaCheck == true)
        {
            $pecaVerified = true;
            $pecaSplitada[0] = $pecaExplode[0];
            $pecaSplitada[1] = $pecaExplode[1];
            $pecaSplitada[2] = $pecaExplode[2];
            $dataCollection['pecaSplitada'] = $pecaSplitada;
        }
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
            $casaSplitada[0] = $caractere;
            $casaSplitada[1] = $casa;
            $casaSplitada[2] = $casaExplode[2];
            $dataCollection['casaSplitada'] = $casaSplitada;
        }
    }
    return (@$casaVerified == true && @$pecaVerified == true) ? $dataCollection : false;
    //final do tratamento dos valores inválidos
}
?>