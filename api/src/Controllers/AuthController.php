<?php declare(strict_types=1);

class AuthController
{
    public function login(): never
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $body     = json_decode(file_get_contents('php://input'), true) ?? [];
        $password = $body['password'] ?? '';

        $expected = getenv('ADMIN_PASSWORD') ?: '';

        if ($expected === '' || !hash_equals($expected, $password)) {
            json_error('Senha incorreta.', 401);
        }

        $_SESSION['admin'] = true;
        json_response(['ok' => true]);
    }

    public function logout(): never
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();
        json_response(['ok' => true]);
    }
}
