<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader;


// Using the CLI factory default services container
$di = new CliDI();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new Loader();

$loader->registerDirs(
    [
        __DIR__ . "/tasks",
    ]
);

$loader->register();

/**
 * Handle routes
 */
include APP_PATH . '/config/router.php';
/**
 * Read services
 */
include APP_PATH . '/config/services.php';

// Load the configuration file (if any)

$configFile = __DIR__ . "/config/config.php";

if (is_readable($configFile)) {
    $config = include $configFile;

    $di->set("config", $config);
}


/**
 * Include Autoloader
 */
include APP_PATH . '/config/loader.php';

// Create a console application
$console = new ConsoleApp();

$console->setDI($di);


/**
 * Process the console arguments
 */
$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments["task"] = $arg;
    } elseif ($k === 2) {
        $arguments["action"] = $arg;
    } elseif ($k >= 3) {
        $arguments["params"][] = $arg;
    }
}

$di->setShared("console", $console);

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();

    exit(255);
}
