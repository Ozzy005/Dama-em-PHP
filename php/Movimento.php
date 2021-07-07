<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function Movimento($tabuleiro,$contadorTurno,$ultimoMovimento,$peca,$casa,$acao)
{
    $dataCollection = CheckInput($peca,$casa);

    if($dataCollection !== false)
    {
        $pecaSplitada = $dataCollection['pecaSplitada'];
        $casaSplitada = $dataCollection['casaSplitada'];

        try
        {
            $regras = CheckRegras($contadorTurno,$ultimoMovimento,$pecaSplitada,$casaSplitada);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

    }
    else
    {
        throw new Exception('Dados recebidos incorretos');
    }

    if($acao === 'mover' && $regras === true )
    {
        $resultado = MoverPeca($tabuleiro,$pecaSplitada,$casaSplitada);
        $tabuleiro = $resultado['tabuleiro'];
        $ultimoMovimento = $resultado['ultimoMovimento'];
        $contadorTurno++;
    }

    return ['tabuleiro' => $tabuleiro, 'contadorTurno' => $contadorTurno, 'ultimoMovimento' => $ultimoMovimento];
}
?>