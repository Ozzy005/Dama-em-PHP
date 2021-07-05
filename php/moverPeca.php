<?php

/**
 *
 * @author Rafael Arend
 *
 **/

 //função responsável por mover a peça no tabuleiro
function moverPeca($acao,$peca,$casa,$tabuleiro,$turnoInicial)
{
    $lanceInicial = 'BRANCAS'; // ainda não utilizado
    $jogadasPorTurno = 1; // ainda não utilizado
    $vezDeJogar = ''; // ainda não utilizado

    if($acao == 'MOVER' && $peca != null && $casa != null)
    {
        //tratamento de valores inválidos recebidos via input do formulário
        $casaExplode = explode('-',$casa);
        $pecaExplode = explode('-',$peca);

        if(count($pecaExplode) == 3)
        {
            $pecaPosUm = ($pecaExplode[0] == 'PECA') ? true : false;
            $pecaPosDois = ($pecaExplode[1] == 'BRANCA' || $pecaExplode[1] == 'PRETA') ? true : false;
            $pecaPosTres = ($pecaExplode[2] >= 1 && $pecaExplode[2] <=12) ? true : false;

            $pecaCheck = ($pecaPosUm == true && $pecaPosDois == true && $pecaPosTres == true) ? true : false;

            $pecaVerified = $pecaCheck == true ? true : false;
        }

        if(count($casaExplode) == 3)
        {
            $casaPosUm = ($casaExplode[0] == 'CASA') ? true : false;
            $caractere = (strlen($casaExplode[1]) == 2) ? substr($casaExplode[1],0,-1) : false;
            $casaPosDois = ($caractere >=1 && $caractere <= 8) ? true : false;
            $casaPosTres= ($casaExplode[2] == 'BRANCA' || $casaExplode[2] == 'PRETA') ? true : false;

            $casaCheck = ($casaPosUm == true && $casaPosDois == true && $casaPosTres == true) ? true : false;

            if($casaCheck == true)
            {
                $casaVerified = true;
                $casaPosition[0] = $caractere;
                $casaPosition[1] = $casa;
                $casaPosition[2] = $casaExplode[2];
            }
        }
        //final do tratamento dos valores inválidos


        //se atender aos requisitos move a peça
        if(@$casaVerified == true && @$pecaVerified == true)
        {
            if($casaPosition[2] == 'PRETA')
            {
                //percorre o tabuleiro
                foreach($tabuleiro as $keyLine => $valueLine)
                {
                    //verifica se a peca existe na linha
                    if($keyCasa = array_search($peca,$valueLine))
                    {
                        //se sim, então guarda a posição da peça em $pecaPosition
                        $pecaPosition = [$keyLine,$keyCasa];
                        break;
                    }
                }
                if(($tabuleiro[$pecaPosition[0]][$pecaPosition[1]]) == $peca)
                {
                    $tabuleiro[$pecaPosition[0]][$pecaPosition[1]] = NULL;
                    $tabuleiro[$casaPosition[0]][$casaPosition[1]] = $peca;
                }
            }
            else
            {
                $msgerror = "<div class='casa-invalida'>Movimento inválido.</div>";
            }
        }
        else
        {
            $msgerror = "<div class='casa-invalida'>Valores de entrada incorretos.</div>";
        }
    }
    return isset($msgerror) ? ['tabuleiro' => $tabuleiro, 'msgerror' => $msgerror] : ['tabuleiro' => $tabuleiro, 'msgerror' => ''];
}
?>