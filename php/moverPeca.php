<?php

/**
 *
 * @author Rafael Arend
 *
 **/

 //função responsável por mover a peça no tabuleiro
function moverPeca($acao,$peca,$casa,$tabuleiro)
{
    if($acao == 'MOVER' && $peca != null && $casa != null)
    {
        //divide a string (CASA-IDENTIFICAÇÃO-COR) em 3 partes
        $casaparts = explode('-',$casa);

        //tratamento de valores inválidos
        if(count($casaparts) == 3 && count(explode('-',$peca)) == 3)
        {
            $pecaTrue = true;

            $casapos[0] = strlen($casaparts[1]) == 2 ? substr($casaparts[1],0,-1) : false;

            $casapos[1] = (strlen($casa) == 13 || strlen($casa) == 14) ? $casa : false;

            $linhaTrue = array_key_exists($casapos[0],$tabuleiro);

            $casaTrue = array_key_exists($casapos[1],$tabuleiro[$casapos[0]]);

            $casaCor = ($casaparts[2] == 'PRETA' || $casaparts[2] == 'BRANCA') ? $casaparts[2] : false;
        }

        //se atender aos requisitos move a peça
        if(isset($linhaTrue) == true && isset($casaTrue) == true && $pecaTrue == true && isset($casaCor) != false)
        {
            if($casaCor == 'PRETA')
            {
                foreach($tabuleiro as $linekey => $linevalue)
                {
                    if($casakey = array_search($peca,$linevalue))
                    {
                        $pecapos = [$linekey,$casakey];
                        break;
                    }
                }
                if(($tabuleiro[$pecapos[0]][$pecapos[1]]) == $peca)
                {
                    $tabuleiro[$pecapos[0]][$pecapos[1]] = NULL;
                    $tabuleiro[$casapos[0]][$casapos[1]] = $peca;
                }
            }
            else
            {
                $msgerror = "<div class='casa-invalida'>Movimento ou valores incorretos.</div>";
            }
        }
        else
        {
            $msgerror = "<div class='casa-invalida'>Movimento ou valores incorretos.</div>";
        }
    }
    return isset($msgerror) ? ['tabuleiro' => $tabuleiro, 'msgerror' => $msgerror] : ['tabuleiro' => $tabuleiro, 'msgerror' => ''];
}
?>