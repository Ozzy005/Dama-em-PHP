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

    public function __construct($data)
    {
        $this->page = file_get_contents('html/board.html');
        $this->data = $data;
    }

    public function show()
    {
        print $this->page;
    }

    public function make()
    {
        $data = $this->data;
        $page = $this->page;
        $markings_html = $data->getValue('markings-html');
        $replace = [];

        $replace[] = $data->getValue('turn');
        $replace[] = $data->getValue('player-current-left');
        $replace[] = $data->getValue('message-error');

        foreach($data->getValue('pieces') as $piece)
        {
            $replace[] = $piece;
        }

        $replace[] = $data->getValue('player-current-top-right');
        $replace[] = $data->getValue('player-top-right');
        $replace[] = $data->getValue('player-current-lower-right');
        $replace[] = $data->getValue('player-lower-right');

        $this->page = str_replace($markings_html, $replace, $page);
    }
}
?>