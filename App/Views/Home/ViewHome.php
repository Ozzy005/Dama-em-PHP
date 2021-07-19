<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class ViewHome
{
    private $page;

    public function __construct()
    {
        $this->page = file_get_contents('html/home.html');
    }

    public function show()
    {
        print $this->page;
    }
}
?>