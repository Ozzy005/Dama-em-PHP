<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function Jogo()
{
    //define todas as variáveis
    Pecas();

    $tabuleiro = key_exists('tabuleiro',$_SESSION) ? $_SESSION['tabuleiro'] : null;
    $contadorTurno = key_exists('contadorTurno',$_SESSION) ? $_SESSION['contadorTurno'] : 1;
    $ultimoMovimento = key_exists('ultimoMovimento',$_SESSION) ? $_SESSION['ultimoMovimento'] : null;

    $peca = key_exists('input-peca',$_POST) ? $_POST['input-peca'] : null;
    $casa = key_exists('input-casa',$_POST) ? $_POST['input-casa'] : null;
    $acao = key_exists('acao',$_POST) ? $_POST['acao'] : null;

    $pecaEscolhida = $_SESSION['peca-escolhida'];
    $msgerror = '';

    if($acao === 'reset')
    {
        $_SESSION = array();

        StartJogo();

        exit();
    }

    if($tabuleiro === null)
    {
        $tabuleiro = GerarTabuleiro(Tabuleiro(),$pecaEscolhida);
    }

    if($peca !== null && $casa !== null)
    {
        try
        {
            $resultado = Movimento($tabuleiro,$contadorTurno,$ultimoMovimento,$peca,$casa,$acao);
        }
        catch(Exception $e)
        {
            $msgerror = "<div class='casa-invalida'>{$e->getMessage()}</div>";
        }

        if(isset($resultado))
        {
            $contadorTurno = $resultado['contadorTurno'];
            $ultimoMovimento = $resultado['ultimoMovimento'];
            $tabuleiro = $resultado['tabuleiro'];

        }
    }

    $pagina = ReplaceValores($tabuleiro,$msgerror);

    if($acao !== 'reset')
    {
        $_SESSION['tabuleiro'] = $tabuleiro;
        $_SESSION['contadorTurno'] = $contadorTurno;
        $_SESSION['ultimoMovimento'] = $ultimoMovimento;

    }

    print $pagina;
}



?>