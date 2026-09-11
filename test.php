<?php

$exitCode = 0;

try {
    if (PHP_OS_FAMILY === 'Windows') {
        runClearCache();
        runLintChecking();
        runTypeChecking();
        runRefactorChecking();
        runTests();
    } else {
        runClearCache();
        runLintChecking();
        runTypeChecking();
        runRefactorChecking();
        runTyposChecking();
        runTests();
    }

    echoSuccess('All checks passed!' . "\n");
} catch (Throwable $th) {
    echoError($th->getMessage() . "\n");
    echoWarning('Please run "composer test" again after you fix the issue.' . "\n\n");
    exit(1);
}

// Echo

function echoWarning($message)
{
    echo "\033[33m" . $message . "\033[0m";
}

function echoError($message)
{
    echo "\033[31m" . $message . "\033[0m";
}

function echoSuccess($message)
{
    echo "\033[32m" . $message . "\033[0m";
}

function echoInfo($message)
{
    echo "\033[34m" . $message . "\033[0m";
}

// Run Checking

function runClearCache()
{
    echoInfo('Clearing cache...' . "\n");
    system('php artisan config:clear --ansi', $exitCode);
    if ($exitCode) {
        throw new Exception('Failed clearing cache.');
    }
}

function runLintChecking()
{
    echoInfo('Lint checking...' . "\n");
    system('composer lint:check', $exitCode);
    if ($exitCode) {
        throw new Exception('Failed lint checking, try run "composer lint" for fixing it.');
    }
}

function runTypeChecking()
{
    echoInfo('Type checking...' . "\n");
    system('composer types:check', $exitCode);
    if ($exitCode) {
        throw new Exception('Failed type checking, try run "composer types" for fixing it.');
    }
}

function runRefactorChecking()
{
    echoInfo('Refactor checking...' . "\n");
    system('composer refactor:check', $exitCode);
    if ($exitCode) {
        throw new Exception('Failed refactor checking, try run "composer refactor" for fixing it.');
    }
}

function runTyposChecking()
{
    echoInfo('Typos checking...' . "\n");
    system('composer typos:check', $exitCode);
    if ($exitCode) {
        throw new Exception('Failed typos checking, try run "composer typos" for fixing it.');
    }
}

function runTests()
{
    echoInfo('Running tests...' . "\n");
    system('php artisan test --compact --parallel', $exitCode);
    if ($exitCode) {
        throw new Exception('There are some failing test, please fix them first.');
    }
}
