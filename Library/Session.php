<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Library;

class Session
{
    public function __construct()
    {
        if (session_status() != 2) {
            session_start();
        }
        if (isset($_SESSION['SESSION_LAST_ACTIVITY'])) {
            if (time() - $_SESSION['SESSION_LAST_ACTIVITY'] > SESSION_LIFETIME) {
                session_unset();
                session_destroy();
            }
        }

        $_SESSION['SESSION_LAST_ACTIVITY'] = time();

        if (!isset($_SESSION['ID_REGENERATION_TIME'])) {
            $_SESSION['ID_REGENERATION_TIME'] = time();
        } elseif (time() - $_SESSION['ID_REGENERATION_TIME'] > SESSION_REGENERATION_ID_LIFETIME) {
            session_regenerate_id(true);
            $_SESSION['ID_REGENERATION_TIME'] = time();
        }
    }

    public static function empty(): bool
    {
        return empty($_SESSION);
    }

    public static function notEmpty(): bool
    {
        return !empty($_SESSION);
    }

    public static function has(string $key): bool
    {
        return !empty($_SESSION[$key]);
    }

    public static function notHas(string $key): bool
    {
        return empty($_SESSION[$key]);
    }

    public static function exists(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        if (self::has($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    public static function destroy(): void
    {
        session_unset();
        session_destroy();
    }
}
