<?php

class AuthController 
{
    private $db;
    
    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function showRegister() 
    {
        require_once VIEWS . 'register.php';
    }
    
    public function showLogin() 
    {
        require_once VIEWS . 'login.php';
    }
    
    public function register() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
        {
            header('Location: index.php?controller=auth&action=showRegister');
            exit;
        }
        
        // Validar dados do formulário
        $errors = [];
        
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Verificar campos obrigatórios
        if (empty($username)) $errors[] = "Nome de utilizador é obrigatório";
        if (empty($email)) $errors[] = "Email é obrigatório";
        if (empty($password)) $errors[] = "Palavra-passe é obrigatória";
        if (empty($first_name)) $errors[] = "Primeiro nome é obrigatório";
        if (empty($last_name)) $errors[] = "Apelido é obrigatório";
        
        // Verificar se as senhas coincidem
        if ($password !== $confirm_password) 
        {
            $errors[] = "As palavras-passe não coincidem";
        }
        
        // Verificar se o email é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $errors[] = "Email inválido";
        }
        
        // Verificar se o nome de utilizador ou email já existem
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM utilizadores WHERE nome_utilizador = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) 
        {
            $errors[] = "Nome de utilizador ou email já estão em uso";
        }
        
        // Se houver erros, voltar para o formulário
        if (!empty($errors)) 
        {
            $_SESSION['register_errors'] = $errors;
            header('Location: index.php?controller=auth&action=showRegister');
            exit;
        }
        
        // Hash da senha
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Criar token de verificação
        $verification_token = bin2hex(random_bytes(32));
        
        // Inserir utilizador no banco de dados
        $stmt = $this->db->prepare("
            INSERT INTO utilizadores (nome_utilizador, email, palavra_passe, primeiro_nome, apelido, token_verificacao, criado_em) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        if ($stmt->execute([$username, $email, $hashed_password, $first_name, $last_name, $verification_token])) 
        {
            // Enviar email de verificação
            $verification_link = "http://localhost:8000/index.php?controller=auth&action=verifyEmail&token=" . $verification_token;
            $subject = 'Verificação de conta - Web Matcha';
            $body = "
                <h1>Bem-vindo ao Web Matcha!</h1>
                <p>Olá {$first_name},</p>
                <p>Obrigado por te registares. Por favor, clica no link abaixo para verificar a tua conta:</p>
                <p><a href='{$verification_link}'>Verificar Conta</a></p>
                <p>Ou copia e cola este link no teu navegador:</p>
                <p>{$verification_link}</p>
                <p>Atenciosamente,<br>Equipa Web Matcha</p>
            ";
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: Web Matcha <noreply@webmatcha.com>" . "\r\n";
            
            mail($email, $subject, $body, $headers);
            
            $_SESSION['success_message'] = "Registo efetuado com sucesso! Verifica o teu email para ativar a conta.";
            header('Location: index.php?controller=auth&action=login');
            exit;
        } 
        else 
        {
            $_SESSION['register_errors'] = ["Ocorreu um erro ao processar o registo. Tenta novamente."];
            header('Location: index.php?controller=auth&action=showRegister');
            exit;
        }
    }
    
    public function login() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
        {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        
        $login = $_POST['login'] ?? ''; // Pode ser username ou email
        $password = $_POST['password'] ?? '';
        
        if (empty($login) || empty($password)) 
        {
            $_SESSION['login_error'] = "Por favor, preencha todos os campos";
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        
        // Verificar se o login é um email ou nome de utilizador
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nome_utilizador';
        
        // Buscar utilizador
        $stmt = $this->db->prepare("SELECT id, palavra_passe, verificado FROM utilizadores WHERE {$field} = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['palavra_passe'])) 
        {
            // Verificar se a conta está verificada
            if (!$user['verificado']) 
            {
                $_SESSION['login_error'] = "Por favor, verifica o teu email para ativar a conta.";
                header('Location: index.php?controller=auth&action=login');
                exit;
            }
            
            // Login bem-sucedido
            $_SESSION['user_id'] = $user['id'];
            
            // Atualizar status online
            $stmt = $this->db->prepare("UPDATE utilizadores SET online = TRUE, ultima_ligacao = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);
            
            // Redirecionar para a página inicial
            header('Location: index.php?controller=home&action=index');
            exit;
        } 
        else 
        {
            $_SESSION['login_error'] = "Nome de utilizador/email ou palavra-passe incorretos";
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }
    
    public function logout() 
    {
        // Atualizar status offline
        if (isset($_SESSION['user_id'])) 
        {
            $stmt = $this->db->prepare("UPDATE utilizadores SET online = FALSE, ultima_ligacao = NOW() WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
        }
        
        // Destruir sessão
        session_destroy();
        
        // Redirecionar para a página de login
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
    
    public function verifyEmail() 
    {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) 
        {
            $_SESSION['login_error'] = "Token de verificação inválido";
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        
        // Verificar token
        $stmt = $this->db->prepare("SELECT id FROM utilizadores WHERE token_verificacao = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) 
        {
            // Atualizar status de verificação
            $stmt = $this->db->prepare("UPDATE utilizadores SET verificado = TRUE, token_verificacao = NULL WHERE id = ?");
            if ($stmt->execute([$user['id']])) 
            {
                $_SESSION['success_message'] = "Conta verificada com sucesso! Agora podes entrar.";
            } 
            else 
            {
                $_SESSION['login_error'] = "Ocorreu um erro ao verificar a conta. Tenta novamente.";
            }
        } 
        else 
        {
            $_SESSION['login_error'] = "Token de verificação inválido ou expirado";
        }
        
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}