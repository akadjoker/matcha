<?php

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = CONTROLLERS . $controllerName . '.php';

if (file_exists($controllerFile)) 
{
    require_once $controllerFile;

    $controllerInstance = new $controllerName();

    if (method_exists($controllerInstance, $action)) 
    {
        $controllerInstance->$action();
    }
    else 
    {
        http_response_code(404);
        require_once VIEWS . 'errors/404.php';
        exit;

        //echo "Ação '$action' não encontrada.";
    }
}
else 
{
    http_response_code(404);
    require_once VIEWS . 'errors/404.php';
    exit;

//    echo "Controlador '$controllerName' não encontrado.";
}
