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

    if(!isset($_SESSION['tabuleiro']))
    {
        $tabuleiro = defineTabuleiro();
        $tabuleiro = organizaTabuleiro($tabuleiro,$peca_escolhida);
    }

    if(isset($_SESSION['tabuleiro']))
    {
        $tabuleiro = $_SESSION['tabuleiro'];
    }

    $returnMoverPeca = moverPeca($acao,$peca,$casa,$tabuleiro);
    $tabuleiro = $returnMoverPeca['tabuleiro'];
    $msgerror = $returnMoverPeca['msgerror'];

    $casas = [];

    foreach($tabuleiro as $linekey => $linevalue)
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

    $content = file_get_contents('html/dama.html');
    $pagina = '';

    $pagina = str_replace($replace,$casas,$content);
    $pagina = str_replace('{msgerror}',$msgerror,$pagina);

    if($acao !== 'RESET')
    {
        $_SESSION['tabuleiro'] = $tabuleiro;
    }

    print $pagina;
}



?>