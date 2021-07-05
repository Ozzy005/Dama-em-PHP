<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function Jogo()
{
    $acao = isset($_POST['acao']) ? $_POST['acao'] : null;

    if($acao == 'reset')
    {
        $_SESSION = array();
        startJogo();

        exit();
    }

    $peca = isset($_POST['input-peca']) ? $_POST['input-peca'] : null;
    $casa = isset($_POST['input-casa']) ? $_POST['input-casa'] : null;
    $peca_escolhida = isset($_SESSION['peca-escolhida']) ? $_SESSION['peca-escolhida'] : null;

    definePecas();
    $replace = defineReplace();

    //se session tabuleiro não estiver definido significa que é o primeiro turno
    if(!isset($_SESSION['tabuleiro']))
    {
        $contadorTurno = 1;
        $tabuleiro = defineTabuleiro();
        $tabuleiro = organizaTabuleiro($tabuleiro,$peca_escolhida);
    }

    //se session tabuleiro estiver definido significa que é o segundo turno em diante
    if(isset($_SESSION['tabuleiro']))
    {
        $contadorTurno = $_SESSION['contadorTurno'];
        $tabuleiro = $_SESSION['tabuleiro'];
    }

    if(isset($casa,$peca))
    {
        $returnMoverPeca = moverPeca($acao,$peca,$casa,$tabuleiro,$contadorTurno);
        $tabuleiro = $returnMoverPeca['tabuleiro'];
        $msgerror = $returnMoverPeca['msgerror'];

        if(isset($returnMoverPeca['contadorTurno']))
        {
            $contadorTurno = $returnMoverPeca['contadorTurno'];
        }

    }
    else{
        $msgerror = '';
    }

    $casas = [];

    foreach($tabuleiro as $linekey => $linevalue)
    {
        foreach($linevalue as $casakey => $casavalue)
        {
            $casakeyparts = explode("-",$casakey);
            $casavalueparts = explode("-",$casavalue);

            $tag = "<div type='text' class='{$casakeyparts[0]} {$casakeyparts[0]}-{$casakeyparts[2]}' id='$casakey'>";

            if($casavalue != null)
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
        $_SESSION['contadorTurno'] = $contadorTurno;
        $_SESSION['tabuleiro'] = $tabuleiro;
    }

    print $pagina;
}



?>