<?php declare(strict_types=1);

define('API_ROOT', dirname(__DIR__));

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

// ---------------------------------------------------------------------------
// Internal helper — writes a structured JSON log line to storage/api_erro.log
// ---------------------------------------------------------------------------
function _writeLog(Throwable $e): void
{
    $logFile = API_ROOT . '/../../storage/api_erro.log';

    // Build relative file path (strip absolute prefix for brevity)
    $absPrefix = realpath(API_ROOT . '/../../') ?: '';
    $relFile    = $absPrefix !== ''
        ? str_replace($absPrefix, '', $e->getFile())
        : $e->getFile();
    $relFile    = ltrim(str_replace('\\', '/', $relFile), '/');

    // First 5 stack-trace frames
    $frames = [];
    foreach (array_slice($e->getTrace(), 0, 5) as $frame) {
        $framePath = $frame['file'] ?? '';
        if ($absPrefix !== '') {
            $framePath = str_replace($absPrefix, '', $framePath);
        }
        $framePath   = ltrim(str_replace('\\', '/', $framePath), '/');
        $frames[]    = sprintf(
            '%s:%s:%s',
            $framePath,
            $frame['line'] ?? '?',
            $frame['function'] ?? '?'
        );
    }

    // Request context
    $method = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
    $url    = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
            . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')
            . ($_SERVER['REQUEST_URI'] ?? '');
    $ip     = $_SERVER['HTTP_X_FORWARDED_FOR']
           ?? $_SERVER['REMOTE_ADDR']
           ?? 'unknown';

    $body = null;
    if (in_array($method, ['POST', 'PUT'], true)) {
        $raw  = file_get_contents('php://input') ?: '';
        $body = mb_substr($raw, 0, 500);
    }

    $entry = json_encode([
        'ts'      => date('c'),
        'level'   => 'CRITICAL',
        'class'   => get_class($e),
        'message' => $e->getMessage(),
        'file'    => $relFile,
        'line'    => $e->getLine(),
        'trace'   => $frames,
        'request' => array_filter([
            'method' => $method,
            'url'    => $url,
            'ip'     => $ip,
            'body'   => $body,
        ], fn($v) => $v !== null),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    file_put_contents($logFile, $entry . PHP_EOL, FILE_APPEND | LOCK_EX);
}

// ---------------------------------------------------------------------------
// Error handler — converts PHP errors to ErrorException (skips /vendor/)
// ---------------------------------------------------------------------------
set_error_handler(function (int $errno, string $errstr, string $errfile, int $errline): bool {
    // Ignore errors that originate inside vendor packages
    if (str_contains(str_replace('\\', '/', $errfile), '/vendor/')) {
        return false; // let PHP handle it normally
    }

    // Only handle the severities we care about
    if (!($errno & (E_WARNING | E_NOTICE | E_PARSE))) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

// ---------------------------------------------------------------------------
// Exception handler — catches any uncaught Throwable, logs and returns JSON
// ---------------------------------------------------------------------------
set_exception_handler(function (Throwable $e): void {
    _writeLog($e);

    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
    }
    echo json_encode(
        ['error' => 'Erro interno. Tente novamente.'],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    exit(1);
});

// ---------------------------------------------------------------------------
// Load .env
// ---------------------------------------------------------------------------
foreach (file(API_ROOT . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
    if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
    [$k, $v] = explode('=', $line, 2);
    $k = trim($k); $v = trim($v);
    if (!getenv($k)) { putenv("$k=$v"); $_ENV[$k] = $v; }
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4',
                getenv('DB_HOST') ?: 'localhost',
                getenv('DB_NAME') ?: 'geek_store'
            ),
            getenv('DB_USER') ?: 'root',
            getenv('DB_PASS') ?: '',
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );
    }
    return $pdo;
}

function json_response(mixed $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function json_error(string $message, int $status = 400): never
{
    json_response(['error' => $message], $status);
}
