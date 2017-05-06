<?php

$config = include __DIR__ . "/../app/config/config.php";

print $config->database->dbname;