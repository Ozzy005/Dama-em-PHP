<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function CheckInput($peca,$casa)
{
    $casaExplode = explode('-',$casa);
    $pecaExplode = explode('-',$peca);

    if(count($pecaExplode) === 3)
    {
        //estrutura do nome de uma peca (PEDRA-COR-NUMERAÇÃO)
        $pecaPosUm = ($pecaExplode[0] === 'pedra') ? true : false;
        $pecaPosDois = ($pecaExplode[1] === 'branca' || $pecaExplode[1] === 'preta') ? true : false;
        $pecaPosTres = ($pecaExplode[2] >= 1 && $pecaExplode[2] <=12) ? true : false;

        $pecaCheck = ($pecaPosUm === true && $pecaPosDois === true && $pecaPosTres === true) ? true : false;

        if($pecaCheck === true)
        {
            $pecaVerified = true;
            $pecaSplitada['tipo'] = $pecaExplode[0];
            $pecaSplitada['cor'] = $pecaExplode[1];
            $pecaSplitada['identificao'] = $pecaExplode[2];
            $pecaSplitada['nome'] = $peca;
            $dataCollection['pecaSplitada'] = $pecaSplitada;
        }
    }

    if(count($casaExplode) === 3)
    {
        //estrutura do nome de uma casa (CASA-LINHA.CASA-COR)
        $casaPosUm = ($casaExplode[0] === 'casa') ? true : false;
        $caractere = (strlen($casaExplode[1]) === 2) ? substr($casaExplode[1],0,-1) : false;
        $casaPosDois = ($caractere >=1 && $caractere <= 8) ? true : false;
        $casaPosTres= ($casaExplode[2] === 'branca' || $casaExplode[2] === 'preta') ? true : false;

        $casaCheck = ($casaPosUm === true && $casaPosDois === true && $casaPosTres === true) ? true : false;

        if($casaCheck === true)
        {
            $casaVerified = true;
            $casaSplitada['tipo'] = $casaExplode[0];
            $casaSplitada['identificao'] = $casaExplode[1];
            $casaSplitada['cor'] = $casaExplode[2];
            $casaSplitada['keyline'] = $caractere;
            $casaSplitada['nome'] = $casa;
            $dataCollection['casaSplitada'] = $casaSplitada;
        }
    }
    return (@$casaVerified === true && @$pecaVerified === true) ? $dataCollection : false;
}
?>