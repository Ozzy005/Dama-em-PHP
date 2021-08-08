<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Core;

class Post
{
    public static function getValue($param)
    {
        if(array_key_exists($param, $_POST))
        {
            return $_POST[$param];
        }
    }
}