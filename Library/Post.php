<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Library;

class Post
{
    public static function empty(): bool
    {
        return empty($_POST);
    }

    public static function has(string $key): bool
    {
        return !empty($_POST[$key]);
    }

    public static function notHas(string $key): bool
    {
        return empty($_POST[$key]);
    }

    public static function exists(string $key): bool
    {
        return array_key_exists($key, $_POST);
    }

    public static function get(string $key): mixed
    {
        if (self::has($key)) {
            return $_POST[$key];
        }

        return null;
    }
}
