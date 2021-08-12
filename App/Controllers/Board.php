<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Controllers;

use Core\Session;
use Core\Data;
use App\Models\DataInput;
use App\Models\Board as BoardModel;
use App\Models\PlayerBoardSide;
use App\Models\PlayerCurrent;
use App\Models\Rules;
use App\Models\Move;
use App\Views\Board\Board as BoardView;
use Exception;

class Board
{
    public function mount()
    {
        try
        {
            $di = new DataInput();
            $di->playerChosen();

            $bm = new BoardModel();
            $bm->make();

            $pbs = new PlayerBoardSide();
            $pbs->make();

            $pc = new PlayerCurrent();
            $pc->make();

            Session::save();
        }
        catch(Exception $e)
        {
            //por enquanto é só um improviso, mas juro que vou melhorar essa parte =D
            //não é pra entrar aqui, a não ser que algum usuário malicioso
            //altere alguma informação no lado do cliente que não deveria ser alterada
            Session::destroy();
            header( 'Location: index.php', true, 302 );
        }
    }

    public function move()
    {
        try
        {
            $di = new DataInput();
            $di->check();

            $r = new Rules();
            $r->check();

            $m = new Move();
            $m->make();

            $pc = new PlayerCurrent();
            $pc->make();

            Session::save();
        }
        catch(Exception $e)
        {
            Data::getInstance()->setValue('message-error',$e->getMessage());
        }
    }

    public function reset()
    {
        Session::destroy();
        header( 'Location: index.php', true, 302 );
    }

    public function show()
    {
        $bv = new BoardView();
        $bv->make();
        $bv->show();
    }
}