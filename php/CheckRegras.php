<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function CheckRegras($contadorTurno,$ultimoMovimento,$pecaSplitada,$casaSplitada)
{
    try
    {
        CheckCorCasa($casaSplitada);
        CheckLanceInicial($contadorTurno,$ultimoMovimento,$pecaSplitada);
        CheckUltimoMovimento($ultimoMovimento,$pecaSplitada);

    }
    catch(Exception $e)
    {
        throw new Exception($e->getMessage());
    }

    return true;
}

function CheckCorCasa($casaSplitada)
{
    if($casaSplitada['cor'] !== 'preta')
    {
        throw new Exception('Não é permitido mover-se para a casa branca');
    }
}

function CheckLanceInicial($contadorTurno,$ultimoMovimento,$pecaSplitada)
{
    if($contadorTurno === 1 && $ultimoMovimento === null)
    {
        if($pecaSplitada['cor'] !== 'branca')
        {
            throw new Exception('Lance inicial deve ser feita pela cor branca');
        }
    }
}

function CheckUltimoMovimento($ultimoMovimento,$pecaSplitada)
{
    if($ultimoMovimento === 'branca' && $pecaSplitada['cor'] !== 'preta')
    {
        throw new Exception('Agora é a vez da cor preta jogar');
    }
    elseif($ultimoMovimento === 'preta' && $pecaSplitada['cor'] !== 'branca')
    {
        throw new Exception('Agora é a vez da cor branca jogar');
    }
}

?>