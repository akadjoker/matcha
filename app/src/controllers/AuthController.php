<?php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            $errors = [];

            if (empty($username) || empty($email) || empty($password) || empty($confirm))
            {
                $errors[] = "Todos os campos são obrigatórios.";
            }

            if ($password !== $confirm)
            {
                $errors[] = "As passwords não coincidem.";
            }

            if ($this->userModel->findByEmail($email))
            {
                $errors[] = "Email já registado.";
            }

            if ($this->userModel->findByUsername($username))
            {
                $errors[] = "Username já em uso.";
            }

            if (empty($errors))
            {
                $token = bin2hex(random_bytes(16));

                $success = $this->userModel->create([
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'token' => $token
                ]);

                if ($success)
                {
                    $link = "http://localhost:8000/index.php?controller=auth&action=verify&token=$token";
                    $subject = "Confirmação de conta Matcha";
                    $message = "Olá $username,\n\nPor favor confirma a tua conta clicando no link abaixo:\n$link";
                    $headers = "From: no-reply@matcha.com";

                    mail($email, $subject, $message, $headers);

     

                    $info = "Registo feito com sucesso! Verifica o teu email.";
                    require_once VIEWS . 'auth/register.php';
                    return;
                }
                else
                {
                    $errors[] = "Erro ao registar utilizador.";
                }
            }

            require_once VIEWS . 'auth/register.php';
        }
        else
        {
            require_once VIEWS . 'auth/register.php';
        }
    }

    public function verify()
    {
        $token = $_GET['token'] ?? '';

        if ($this->userModel->activateUser($token))
        {
            $message = "Conta ativada com sucesso! Já podes iniciar sessão.";
        }
        else
        {
            $message = "Token inválido ou conta já ativada.";
        }

        require_once VIEWS . 'auth/verify.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->validateLogin($email, $password);

            if ($user)
            {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['avatar'] = $user['avatar'];
                header("Location: index.php");
                exit;
            }
            else
            {
                $error = "Credenciais inválidas ou conta não verificada.";
                require_once VIEWS . 'auth/login.php';
                return;
            }
        }

        require_once VIEWS . 'auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit;
    }
}
