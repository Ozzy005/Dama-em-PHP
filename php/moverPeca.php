<?php

/**
 *
 * @author Rafael Arend
 *
 **/

 //função responsável por mover a peça no tabuleiro
function moverPeca($acao,$peca,$casa,$tabuleiro,$turnoInicial)
{

    $lanceInicial = 'brancas'; // ainda não utilizado
    $jogadasPorTurno = 1; // ainda não utilizado
    $vezDeJogar = ''; // ainda não utilizado

    if($acao == 'mover')
    {
        //se o valores forem válidos entra no bloco de execução
        if($casaPosition = checkInput($casa,$peca))
        {
            //só ira mover a peça se a casa alvo for da cor preta
            if($casaPosition[2] == 'preta')
            {
                //percorre o tabuleiro
                foreach($tabuleiro as $keyLine => $valueLine)
                {
                    //verifica se a peca existe na linha
                    if($keyCasa = array_search($peca,$valueLine))
                    {
                        //se sim, então guarda a posição da peça em $pecaPosition e encerra o laço foreach
                        $pecaPosition = [$keyLine,$keyCasa];
                        break;
                    }
                }
                //move a peça pra nova casa e anula a casa antiga
                if(($tabuleiro[$pecaPosition[0]][$pecaPosition[1]]) == $peca)
                {
                    $tabuleiro[$pecaPosition[0]][$pecaPosition[1]] = null;
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