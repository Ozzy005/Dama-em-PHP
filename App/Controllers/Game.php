<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Game
{
    private $data;

    public function __construct()
    {
        new Session();
    }

    public function setData()
    {
        $this->data = new Data;
    }

    public function mountBoard()
    {
        $mb = new MountBoard($this->data);
        $mb->make();

        $pbs = new PlayerBoardSide($this->data);
        $pbs->make();

        $pc = new PlayerCurrent($this->data);
        $pc->make();

        Session::save($this->data);
    }

    public function move()
    {
        try
        {
            $di = new DataInput($this->data);
            $di->check();

            $rules = new Rules($this->data);
            $rules->check();

            $mp = new MovePiece($this->data);
            $mp->make();

            $pc = new PlayerCurrent($this->data);
            $pc->make();

            Session::save($this->data);

        }
        catch(Exception $e)
        {
            $this->data->setValue('message-error',$e->getMessage());
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
        if(empty(array_filter($_SESSION)))
        {
            $vb = new ViewHome();
            $vb->show();
        }
        else
        {
            $pieces = new Pieces($this->data);
            $pieces->make();

            $me = new MessageError($this->data);
            $me->make();

            $vh = new ViewBoard($this->data);
            $vh->make();
            $vh->show();
        }
    }
}



?>