<?php

use NikosGlikis\Object0rPhpHelpers\Helpers\EnvironmentHelper;

require_once APP_PATH . '/../vendor/autoload.php';


if (!defined('ENV')) {

    $xEnvName = '_x_env';

    $env = isset($defaultEnv) ? $defaultEnv : 'prod';

    if (!EnvironmentHelper::isCommandLineInterface()) {

        if (isset($_GET[$xEnvName])) {
            $env = $_GET[$xEnvName];
        }

        if (isset($_POST[$xEnvName])) {
            $env = $_POST[$xEnvName];
        }

        if (isset($_COOKIE[$xEnvName])) {
            $env = $_COOKIE[$xEnvName];
        }
    } else {
        if (getenv($xEnvName)) {
            $env = getenv($xEnvName);
        }
    }

    define('ENV', $env);
    if (ENV == 'prod') {
        ini_set("display_errors", 0);
        ini_set("log_errors", 1);

        //Define where do you want the log to go, syslog or a file of your liking with
        //ini_set("error_log", "syslog"); // or ini_set("error_log", "/path/to/syslog/file");
    }
}
