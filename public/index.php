<?php
include (dirname(__DIR__ ) . '/vendor/Autoload.php');
$config = include(dirname(__DIR__ ) . '/main/config.php');
\App\main\App::call()->run($config);
