<?php

/**
 *
 * @author Rafael Arend
 *
 **/

//Inicia o jogo
function startJogo()
{

    //Cria ou restaura uma sessão caso ela não existir
    $estadoSession = session_status();

    if($estadoSession === 0 or $estadoSession === 1)
    {
        session_start();
    }

    //se peca-escolhida ESTIVER definida em POST OU SESSION ele executa o jogo
    if(isset($_POST['peca-escolhida']) or isset($_SESSION['peca-escolhida']))
    {
        //se peca-escolhida NÃO ESTIVER definida na variável global SESSION, então ira defini-la
        if(!isset($_SESSION['peca-escolhida']))
        {
            $_SESSION['peca-escolhida'] = $_POST['peca-escolhida'];
        }

        Jogo();

    }

    //se peca-escolhida NÃO ESTIVER definida em POST e SESSION ele chama a página inicial
    elseif(!isset($_POST['peca-escolhida']) && !isset($_SESSION['peca-escolhida']))
    {
        $pagina = file_get_contents('html/start.html');
        print $pagina;
    }
}
?>