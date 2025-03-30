<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bulma Dark Theme + Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulmaswatch@0.8.1/darkly/bulmaswatch.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        .avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .box-hover:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .is_mobile {
            display: none;
        }

        @media (max-width: 1060px) {
            .is_mobile {
                display: block;
            }
        }

        @media (min-width: 1059px) {
            .is_mobile {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<?php
    $avatar = !empty($_SESSION['avatar']) ? 'uploads/' . $_SESSION['avatar'] : '/images/default.png';
?>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <strong>Matcha</strong>
        </a>

        <!-- Avatar para mobile -->
        <?php if (!empty($_SESSION['user_id'])): ?>
            <div class="navbar-item is-hidden-desktop">
                <img src="<?= $avatar ?>" alt="Avatar" class="avatar-small">
            </div>
        <?php endif; ?>

        <!-- Burger -->
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navMenu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navMenu" class="navbar-menu">
        <div class="navbar-start">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a class="navbar-item" href="index.php?controller=search&action=index">
                    <i class="fas fa-search mr-2"></i> Procurar
                </a>
                <a class="navbar-item" href="index.php?controller=browse&action=index">
                    <i class="fas fa-users mr-2"></i> Utilizadores
                </a>

                <div class="navbar-dropdown is-right is_mobile">
                    <a class="navbar-item" href="index.php?controller=profile&action=view&id=<?= $_SESSION['user_id'] ?>">
                        <i class="fas fa-user mr-2"></i> Meu Perfil
                    </a>
                    <a class="navbar-item" href="index.php?controller=auth&action=logout">
                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                    </a>
                </div>
            <?php else: ?>
                <a class="navbar-item" href="index.php?controller=auth&action=login">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>
                <a class="navbar-item" href="index.php?controller=auth&action=register">
                    <i class="fas fa-user-plus mr-2"></i> Registar
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <div class="navbar-end is-hidden-touch">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <img src="<?= $avatar ?>" class="avatar-small mr-2">
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </a>
                    <div class="navbar-dropdown is-right">
                        <a href="index.php?controller=profile&action=view&id=<?= $_SESSION['user_id'] ?>" class="navbar-item">
                            <i class="fas fa-user mr-2"></i> Perfil
                        </a>
                        <a href="index.php?controller=auth&action=logout" class="navbar-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>

<section class="section">
    <div class="container">
