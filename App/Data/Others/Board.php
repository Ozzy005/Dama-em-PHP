<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Board
{
    private static $board =
    [
        'line-8' =>
        [
            'column-a-white' => null,
            'column-b-black' => null,
            'column-c-white' => null,
            'column-d-black' => null,
            'column-e-white' => null,
            'column-f-black' => null,
            'column-g-white' => null,
            'column-h-black' => null
        ],
        'line-7' =>
        [
            'column-a-black' => null,
            'column-b-white' => null,
            'column-c-black' => null,
            'column-d-white' => null,
            'column-e-black' => null,
            'column-f-white' => null,
            'column-g-black' => null,
            'column-h-white' => null
        ],
        'line-6' =>
        [
            'column-a-white' => null,
            'column-b-black' => null,
            'column-c-white' => null,
            'column-d-black' => null,
            'column-e-white' => null,
            'column-f-black' => null,
            'column-g-white' => null,
            'column-h-black' => null
        ],
        'line-5' =>
        [
            'column-a-black' => null,
            'column-b-white' => null,
            'column-c-black' => null,
            'column-d-white' => null,
            'column-e-black' => null,
            'column-f-white' => null,
            'column-g-black' => null,
            'column-h-white' => null
        ],
        'line-4' =>
        [
            'column-a-white' => null,
            'column-b-black' => null,
            'column-c-white' => null,
            'column-d-black' => null,
            'column-e-white' => null,
            'column-f-black' => null,
            'column-g-white' => null,
            'column-h-black' => null
        ],
        'line-3' =>
        [
            'column-a-black' => null,
            'column-b-white' => null,
            'column-c-black' => null,
            'column-d-white' => null,
            'column-e-black' => null,
            'column-f-white' => null,
            'column-g-black' => null,
            'column-h-white' => null
        ],
        'line-2' =>
        [
            'column-a-white' => null,
            'column-b-black' => null,
            'column-c-white' => null,
            'column-d-black' => null,
            'column-e-white' => null,
            'column-f-black' => null,
            'column-g-white' => null,
            'column-h-black' => null
        ],
        'line-1' =>
        [
            'column-a-black' => null,
            'column-b-white' => null,
            'column-c-black' => null,
            'column-d-white' => null,
            'column-e-black' => null,
            'column-f-white' => null,
            'column-g-black' => null,
            'column-h-white' => null
        ]
    ];

    public static function getValue()
    {
        return self::$board;
    }
}


