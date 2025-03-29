<?php

session_start();

define('ROOT', dirname(__FILE__));
define('ROOT_PATH', dirname(__FILE__));
define('BASE_URL', '/app/public/');
define('CONFIG', ROOT_PATH . '/config/');
define('CONTROLLERS', ROOT_PATH . '/controllers/');
define('MODELS', ROOT_PATH . '/models/');
define('VIEWS', ROOT_PATH . '/views/');
define('PUBLIC_PATH', ROOT_PATH . '/public');

require_once CONFIG . 'database.php';
require_once CONTROLLERS . 'AuthController.php';
require_once CONTROLLERS . 'HomeController.php';



// Para desenvolvimento - simular utilizador logado
// if (!isset($_SESSION['user_id'])) 
// {
//     $_SESSION['user_id'] = 1; // ID temporário para desenvolvimento
//     $_SESSION['username'] = 'dev_user';
// }

// Definir rota padrão
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Converter primeira letra para maiúscula
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = CONTROLLERS . $controllerName . '.php';


if (file_exists($controllerFile)) 
{
    require_once $controllerFile;
    
    $controller = new $controllerName();
    
    // Verificar se o utilizador está autenticado para rotas protegidas
    // $public_routes = [
    //     'auth|showRegister',
    //     'auth|register',
    //     'auth|login',
    //     'auth|showLogin',
    //     'auth|verifyEmail',
    //     'home|index'
    // ];
    
    // $current_route = strtolower($controllerName) . '|' . $action;
    // $current_route = str_replace('controller', '', $current_route);
    
    // if (!in_array($current_route, $public_routes) && !isset($_SESSION['user_id'])) 
    // {
    //     header('Location: index.php?controller=auth&action=login');
    //     exit;
    // }
    
    if (method_exists($controller, $action)) 
    {
        $controller->$action();
    } 
    else 
    {
        echo 'Página não encontrada! :( Ups!';
        header('HTTP/1.0 404 Not Found');
        require_once VIEWS . '404.php';
    }
} 
else 
{
    echo 'Página não encontrada! :( Ups!';
    header('HTTP/1.0 404 Not Found');
    require_once VIEWS . '404.php';
}

