<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function StartJogo()
{
    $estadoSession = session_status();

    if($estadoSession === 0 || $estadoSession === 1)
    {
        session_start();
    }

    if(!key_exists('peca-escolhida',$_POST) && !key_exists('peca-escolhida',$_SESSION) || !key_exists('peca-escolhida',$_POST) && $_SESSION['peca-escolhida'] === null)
    {
        $_POST['peca-escolhida'] = null;
        $_SESSION['peca-escolhida'] = null;
    }

    if($_SESSION['peca-escolhida'] !== null || $_POST['peca-escolhida'] !== null)
    {
        if($_SESSION['peca-escolhida'] === null)
        {
            $_SESSION['peca-escolhida'] = $_POST['peca-escolhida'];
        }
        Jogo();
    }
    elseif($_SESSION['peca-escolhida'] === null && $_POST['peca-escolhida'] === null)
    {
        $pagina = file_get_contents('html/start.html');
        print $pagina;
    }
}
?>