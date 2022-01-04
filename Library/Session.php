<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Library;

use Library\Tree\Tree;

class Session
{
    private static Tree $tree;

    public function __construct()
    {
        self::start();
        self::$tree = new Tree($_SESSION);
        self::lifetime();
        self::regenerate();
    }

    private static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    private static function lifetime(): void
    {
        if (self::missing('sessionLifetime')) {
            self::put('sessionLifetime', time());
        }
        if ((time() - self::get('sessionLifetime')) > SESSION_LIFETIME) {
            self::destroy();
        }
    }

    private static function regenerate(): void
    {
        if (self::missing('regenerateSession')) {
            self::put('regenerateSession', time());
        }
        if ((time() - self::get('regenerateSession')) > REGENERATE_SESSION) {
            session_regenerate_id(true);
            self::put('regenerateSession', time());
        }
    }

    public static function has(string $key): bool
    {
        return self::$tree->has($key);
    }

    public static function missing(string $key): bool
    {
        return self::$tree->has($key) ? false : true;
    }

    public static function exists(string $key): bool
    {
        return self::$tree->exists($key);
    }

    public static function get(string $key): mixed
    {
        return self::$tree->get($key);
    }

    public static function put(string $key, mixed $value): void
    {
        self::$tree->set($key, $value);
        $_SESSION = self::$tree->getTree();
    }

    public static function push(string $key, mixed $value): void
    {
        self::$tree->add($key, $value);
        $_SESSION = self::$tree->getTree();
    }

    public static function forget(string $key): void
    {
        self::$tree->remove($key);
        $_SESSION = self::$tree->getTree();
    }

    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}
