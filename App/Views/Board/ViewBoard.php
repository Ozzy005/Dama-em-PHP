<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class ViewBoard
{
    private $page;
    private $data;

    public function __construct()
    {
        $this->page = file_get_contents('html/board.html');
        $this->data = Data::getInstance();
    }

    public function show()
    {
        print $this->page;
    }

    public function make()
    {
        $page = $this->page;
        $markings_html = $this->data->getValue('markings-html');
        $replace = [];

        $replace[] = $this->data->getValue('turn');
        $replace[] = $this->data->getValue('player-current-left');
        $replace[] = $this->data->getValue('message-error');

        foreach($this->data->getValue('pieces') as $piece)
        {
            $replace[] = $piece;
        }

        $replace[] = $this->data->getValue('player-current-top-right');
        $replace[] = $this->data->getValue('player-top-right');
        $replace[] = $this->data->getValue('player-current-lower-right');
        $replace[] = $this->data->getValue('player-lower-right');

        $this->page = str_replace($markings_html, $replace, $page);
    }
}