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

}
