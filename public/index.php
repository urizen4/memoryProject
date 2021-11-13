<?php
header("Access-Control-Allow-Origin: *");
 header('Access-Control-Allow-Credentials: true');
 header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
 header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 header("Content-Type: application/json; charset=UTF-8");
 

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
