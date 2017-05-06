<?php

/*
  +------------------------------------------------------------------------+
  | Phalcon Developer Tools                                                |
  +------------------------------------------------------------------------+
  | Copyright (c) 2011-2016 Phalcon Team (https://www.phalconphp.com)      |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Authors: Andres Gutierrez <andres@phalconphp.com>                      |
  |          Eduar Carvajal <eduar@phalconphp.com>                         |
  |          Serghei Iakovlev <serghei@phalconphp.com>                     |
  +------------------------------------------------------------------------+
*/

if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    list($url, $other) = explode('?', $_SERVER['REQUEST_URI']);
    $_GET['_url'] = $url;
    if ($other) {
        $params = explode('&', $other);
        foreach ($params as $param) {
            list($key, $value) = explode('=', $param);
            $_GET[$key] = $value;
        }
    }
}
return false;
