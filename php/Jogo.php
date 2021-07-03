<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function Jogo()
{
    $acao = isset($_POST['acao']) ? strtoupper($_POST['acao']) : null;

    if($acao == 'RESET')
    {
        $_SESSION = array();
        startJogo();

        exit();
    }

    $peca = isset($_POST['input-peca']) ? strtoupper($_POST['input-peca']) : null;
    $casa = isset($_POST['input-casa']) ? strtoupper($_POST['input-casa']) : null;
    $peca_escolhida = isset($_SESSION['peca-escolhida']) ? strtoupper($_SESSION['peca-escolhida']) : null;

    definePecas();
    $replace = defineReplace();

    if(!isset($_SESSION['TABULEIRO']))
    {
        $TABULEIRO = defineTabuleiro($peca_escolhida);
    }

    if(isset($_SESSION['TABULEIRO']))
    {
        $TABULEIRO = $_SESSION['TABULEIRO'];
    }

    if($acao == 'MOVER' && $peca != null && $casa != null)
    {
        $casaparts = explode('-',$casa);
        $casapos[] = substr($casaparts[1],0,-1);
        $casapos[] = $casa;


        if(($TABULEIRO[$casapos[0]][$casapos[1]]) == NULL && $casaparts[2] == 'PRETA')
        {

            foreach($TABULEIRO as $linekey => $linevalue)
            {
                if($casakey = array_search($peca,$linevalue))
                {
                    $pecapos = [$linekey,$casakey];
                    break;
                }
            }
            if(($TABULEIRO[$pecapos[0]][$pecapos[1]]) == $peca)
            {
                $TABULEIRO[$pecapos[0]][$pecapos[1]] = NULL;
                $TABULEIRO[$casapos[0]][$casapos[1]] = $peca;
            }
        }
        else
        {
            $error = 'MOVIMENTO INVÁLIDO';

            $msgerror = "<div class='casa-invalida'>$error</div>";
        }
    }

    $casas = [];

    foreach($TABULEIRO as $linekey => $linevalue)
    {
        foreach($linevalue as $casakey => $casavalue)
        {

            $casakey = strtolower($casakey);
            $casavalue = strtolower($casavalue);

            $casakeyparts = explode("-",$casakey);
            $casavalueparts = explode("-",$casavalue);

            $tag = "<div type='text' class='{$casakeyparts[0]} {$casakeyparts[0]}-{$casakeyparts[2]}' id='$casakey'>";

            if($casavalue != NULL)
            {

                $tag .= "<div class='{$casavalueparts[0]} {$casavalueparts[0]}-{$casavalueparts[1]}' id='$casavalue'></div>";
            }

            $tag .= "</div>";

            $casas[] = $tag;
        }
    }

    if(!isset($msgerror))
    {
        $msgerror = '';
    }

    $content = file_get_contents('html/dama.html');
    $pagina = '';

    $pagina = str_replace($replace,$casas,$content);
    $pagina = str_replace('{msgerror}',$msgerror,$pagina);

    if($acao !== 'RESET')
    {
        $_SESSION['TABULEIRO'] = $TABULEIRO;
    }

    print $pagina;
}



?>