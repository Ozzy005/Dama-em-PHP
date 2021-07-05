<?php

/**
 *
 * @author Rafael Arend
 *
 **/

 //função responsável por mover a peça no tabuleiro
function moverPeca($acao,$peca,$casa,$tabuleiro,$contadorTurno)
{
    $jogadasPorTurno = 1; // ainda não utilizado
    $vezDeJogar = ''; // ainda não utilizado

    $dataCollection = checkInput($casa,$peca);

    //se o valores forem válidos entra no bloco de execução
    if($acao == 'mover' && $dataCollection != false && $dataCollection['casaSplitada'][2] == 'preta')
    {
        $casaSplitada = $dataCollection['casaSplitada'];
        $pecaSplitada = $dataCollection['pecaSplitada'];

        if($contadorTurno == 1)
        {
            if($pecaSplitada[1] == 'branca')
            {
                //percorre o tabuleiro
                foreach($tabuleiro as $keyLine => $valueLine)
                {
                    //verifica se a peca existe na linha
                    if($keyCasa = array_search($peca,$valueLine))
                    {
                        //se sim, então guarda a posição da peça em $pecaSplitada e encerra o laço foreach
                        $pecaSplitada = [$keyLine,$keyCasa];
                        break;
                    }
                }

                //move a peça pra nova casa e anula a casa antiga
                if(($tabuleiro[$pecaSplitada[0]][$pecaSplitada[1]]) == $peca)
                {
                        $tabuleiro[$pecaSplitada[0]][$pecaSplitada[1]] = null;
                        $tabuleiro[$casaSplitada[0]][$casaSplitada[1]] = $peca;
                }
                $contadorTurno++;

            }
            else{
                $msgerror = "<div class='casa-invalida'>Brancas devem fazer o lance inicial.</div>";
            }
        }
        else
        {
            //percorre o tabuleiro
            foreach($tabuleiro as $keyLine => $valueLine)
            {
                //verifica se a peca existe na linha
                if($keyCasa = array_search($peca,$valueLine))
                {
                    //se sim, então guarda a posição da peça em $pecaSplitada e encerra o laço foreach
                    $pecaSplitada = [$keyLine,$keyCasa];
                    break;
                }
            }

            //move a peça pra nova casa e anula a casa antiga
            if(($tabuleiro[$pecaSplitada[0]][$pecaSplitada[1]]) == $peca)
            {
                $tabuleiro[$pecaSplitada[0]][$pecaSplitada[1]] = null;
                $tabuleiro[$casaSplitada[0]][$casaSplitada[1]] = $peca;
            }
        }
    }
    else
    {
        $msgerror = "<div class='casa-invalida'>Movimento ou valores de entrada incorretos.</div>";
    }
    return isset($msgerror) ?
                            [
                                'tabuleiro' => $tabuleiro,
                                'msgerror' => $msgerror
                            ]
                            :
                            [
                                'tabuleiro' => $tabuleiro,
                                'contadorTurno' => $contadorTurno,
                                'msgerror' => ''
                            ];
}
?>