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
    }

    public function move()
    {
        try
        {
            $di = new DataInput();
            $di->check();

            $rules = new Rules();
            $rules->check();

            $mp = new MovePiece();
            $mp->make();

            $pc = new PlayerCurrent();
            $pc->make();
        }
        catch(Exception $e)
        {
            $data = Data::getInstance();
            $data->setValue('message-error',$e->getMessage());
        }
    }

    public function capture()
    {
        //ainda não criado
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