<?php

/**
 * SAMS — Software Agency Management System
 * Front Controller: every request enters here (see .htaccess).
 */

declare(strict_types=1);

use App\Core\App;

define('BASE_PATH', __DIR__);
define('APP_START', microtime(true));

/*
 * PSR-4 autoloader for the App\ namespace.
 * Composer-compatible (composer.json mirrors this mapping), but the app
 * runs with zero vendor dependencies — required for InfinityFree hosting.
 */
spl_autoload_register(static function ($class) {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, 4) === 0) {
        $relative = substr($class, 4);
        $file = BASE_PATH . '/app/' . str_replace('\\', '/', $relative) . '.php';
        if (is_file($file)) {
            require $file;
        }
    }
});

require BASE_PATH . '/app/Helpers/functions.php';

$app = new App();

require BASE_PATH . '/routes/web.php';

$app->run();
