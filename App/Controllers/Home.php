<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Controllers;

use App\Views\Home\Home as HomeView;

class Home
{
    public function show()
    {
        $hv = new HomeView();
        $hv->make();
        $hv->show();
    }
}