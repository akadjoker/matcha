<?php
class HomeController 
{
    public function __construct() 
    {
        
    }
    
    public function index() 
    {
        $dbTest = new Database();
        $conn = $dbTest->getConnection();
        $dbStatus = $conn ? 'Conexão com o banco de dados: OK' : 'Erro na conexão com o banco de dados';
        require_once ROOT_PATH . '/views/home.php';
    }
    
    protected function redirect($url) 
    {
        header("Location: $url");
        exit;
    }
}