<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function MoverPeca($tabuleiro,$pecaSplitada,$casaSplitada)
{
    foreach($tabuleiro as $keyLine => $valueLine)
    {
        if($keyCasa = array_search($pecaSplitada['nome'],$valueLine))
        {
            $pecaSplitada['posicao'] = [$keyLine,$keyCasa];
            break;
        }
    }

    if(($tabuleiro[$pecaSplitada['posicao'][0]][$pecaSplitada['posicao'][1]]) === $pecaSplitada['nome'])
    {
        $tabuleiro[$pecaSplitada['posicao'][0]][$pecaSplitada['posicao'][1]] = null;
        $tabuleiro[$casaSplitada['keyline']][$casaSplitada['nome']] = $pecaSplitada['nome'];
    }

    return ['tabuleiro' => $tabuleiro,'ultimoMovimento' => $pecaSplitada['cor']];
}

?>