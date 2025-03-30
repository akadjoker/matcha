<?php

session_start();

// Caminhos base
define('ROOT_PATH', realpath(__DIR__ . '/../'));
define('SRC', ROOT_PATH . '/src/');
define('PUBLIC_PATH', ROOT_PATH . '/public/');
define('VIEWS', SRC . 'views/');
define('CONTROLLERS', SRC . 'controllers/');
define('MODELS', SRC . 'models/');
define('CONFIG', SRC . 'config/');

 
spl_autoload_register(function ($class)
{
    $paths = [CONTROLLERS, MODELS];
    
    foreach ($paths as $path)
    {
        $file = $path . $class . '.php';

        if (file_exists($file))
        {
            require_once $file;
            return;
        }
    }
});

require_once CONFIG . 'database.php';

// set_exception_handler(function ($e)
// {
//     error_log($e); // para logs internos
//     http_response_code(500);
//     require_once VIEWS . 'errors/500.php';
//     exit;
// });

// set_error_handler(function ($errno, $errstr, $errfile, $errline)
// {
//     throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
// });

// register_shutdown_function(function ()
// {
//     $error = error_get_last();
//     if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR]))
//     {
//         http_response_code(500);
//         require_once VIEWS . 'errors/500.php';
//         exit;
//     }
// });
