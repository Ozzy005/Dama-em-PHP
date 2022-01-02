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
        if (session_status() !== 2) {
            session_start();
        }

        if ($this->has('SESSION_LIFETIME')) {
            if ((time() - $this->get('SESSION_LIFETIME')) > SESSION_LIFETIME) {
                $this->destroy();
            }
        }

        $this->put('SESSION_LIFETIME', time());

        if ($this->notHas('REGENERATE_SESSION')) {
            $this->put('REGENERATE_SESSION', time());
        } elseif ((time() - $this->get('REGENERATE_SESSION')) > REGENERATE_SESSION) {
            session_regenerate_id(true);
            $this->put('REGENERATE_SESSION', time());
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
        return key_exists($key, $_SESSION);
    }

    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        return self::has($key) ? $_SESSION[$key] : null;
    }

    public static function destroy(): void
    {
        if (session_status() === 2) {
            session_unset();
            session_destroy();
        }
    }
}
