<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Game
{
    public function __construct()
    {
        new Session();
    }

    public function mountBoard()
    {
        Session::setVars();

        $mb = new MountBoard();
        $mb->make();

        $pbs = new PlayerBoardSide();
        $pbs->make();

        $pc = new PlayerCurrent();
        $pc->make();

        Session::save();
    }

    public function move()
    {
        try
        {
            $di = new DataInput();
            $di->check();

            $tm = new TypeMove();
            $tm->check();

            $rules = new Rules();
            $rules->check();

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
    }

    public function show()
    {
        if(!Session::empty())
        {
            $p = new Pieces();
            $p->make();

            $me = new MessageError();
            $me->make();

            $vh = new ViewBoard();
            $vh->make();
            $vh->show();
        }
        else
        {
            $vb = new ViewHome();
            $vb->show();
        }
    }
}