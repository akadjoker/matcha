<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Matcha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="index.php?controller=home&action=index">
                    <strong>Web Matcha</strong>
                </a>
                
                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasic">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
            
            <div id="navbarBasic" class="navbar-menu">
                <div class="navbar-start">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="navbar-item" href="index.php?controller=auth&action=browse">
                            <i class="fas fa-search mr-2"></i> Explorar
                        </a>
                        <a class="navbar-item" href="index.php?controller=user&action=search">
                            <i class="fas fa-filter mr-2"></i> Pesquisar
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="navbar-end">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="navbar-item" href="index.php?controller=chat">
                            <i class="fas fa-comments mr-2"></i> Chat
                        </a>
                        <a class="navbar-item" href="/notifications">
                            <i class="fas fa-bell mr-2"></i> Notificações
                        </a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">
                                <i class="fas fa-user mr-2"></i> Perfil
                            </a>
                            
                            <div class="navbar-dropdown is-right">
                                <a class="navbar-item" href="/profile">
                                    Ver perfil
                                </a>
                                <a class="navbar-item" href="/profile/edit">
                                    Editar perfil
                                </a>
                                <hr class="navbar-divider">
                                <a class="navbar-item" href="index.php?controller=auth&action=logout">
                                    Sair
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="navbar-item">
                            <div class="buttons">
                                <a class="button is-primary" href="index.php?controller=auth&action=showRegister">
                                    <strong>Registar</strong>
                                </a>
                                <a class="button is-light" href="index.php?controller=auth&action=showLogin">
                                    Entrar
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="container mt-4">
            <div class="notification is-danger">
                <?php echo $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="container mt-4">
            <div class="notification is-success">
                <?php echo $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        </div>
    <?php endif; ?>