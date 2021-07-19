<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class PiecesWhite
{
    private static $pieces_white =
    [
        1 => "stone-white-1",
        2 => "stone-white-2",
        3 => "stone-white-3",
        4 => "stone-white-4",
        5 => "stone-white-5",
        6 => "stone-white-6",
        7 => "stone-white-7",
        8 => "stone-white-8",
        9 => "stone-white-9",
        10 => "stone-white-10",
        11 => "stone-white-11",
        12 => "stone-white-12"
    ];

    public function getValue()
    {
        return self::$pieces_white;
    }
}