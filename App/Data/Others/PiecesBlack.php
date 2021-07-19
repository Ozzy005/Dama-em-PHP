<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class PiecesBlack
{
    private static $pieces_black =
    [
        1 => "stone-black-1",
        2 => "stone-black-2",
        3 => "stone-black-3",
        4 => "stone-black-4",
        5 => "stone-black-5",
        6 => "stone-black-6",
        7 => "stone-black-7",
        8 => "stone-black-8",
        9 => "stone-black-9",
        10 => "stone-black-10",
        11 => "stone-black-11",
        12 => "stone-black-12"
    ];

    public function getValue()
    {
        return self::$pieces_black;
    }
}