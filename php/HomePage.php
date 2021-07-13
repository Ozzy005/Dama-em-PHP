<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class HomePage
{
    public function start()
    {
        if( session_status() !== 2 )
        {
            session_start();
        }

        if( isset( $_POST['peca-escolhida'] ) || isset( $_SESSION['peca-escolhida'] ) )
        {
            if( !isset( $_SESSION['peca-escolhida'] ) )
            {
                $_SESSION['peca-escolhida'] = $_POST['peca-escolhida'];
            }

            $Game = new Game();
            $Game->start();
        }
        else
        {
            print file_get_contents('html/HomePage.html');
        }
    }
}
?>