<?php declare(strict_types=1);

class AdminMiddleware
{
    public static function check(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['admin'])) {
            json_error('Não autorizado.', 401);
        }
    }
}
