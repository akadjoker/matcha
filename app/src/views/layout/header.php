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

        .navbar-item .tag {
            font-size: 0.75rem;
            padding: 0.2em 0.6em;
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
$notificacaoLikes = 0;

if (!empty($_SESSION['user_id']))
{
    require_once MODELS . 'LikeModel.php';
    $likeModel = new LikeModel();

    $allLikes = $likeModel->getUsersWhoLikedMe($_SESSION['user_id']);
    $likesGiven = $likeModel->getLikesGivenByUser($_SESSION['user_id']);

    // Filtrar apenas os que ainda não foram retribuídos
    $likesPendentes = array_filter($allLikes, fn($u) => !in_array($u['id'], $likesGiven));
    $notificacaoLikes = count($likesPendentes);
}
?>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <strong>Matcha</strong>
        </a>

        <!-- Avatar para mobile, com click abrimos nosso perfil-->
        <?php if (!empty($_SESSION['user_id'])): ?>
            <div class="navbar-item is-hidden-desktop">
                <a href="index.php?controller=profile&action=index">
                    <img src="<?= $avatar ?>" alt="Avatar" class="avatar-small">
                </a>
            </div>
        <?php endif; ?>

        <!-- Burger +- :P -->
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navMenu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navMenu" class="navbar-menu">
        <div class="navbar-start">
            <?php if (!empty($_SESSION['user_id'])): ?>

       


                <a class="navbar-item" href="index.php?controller=match&action=index">
                    <i class="fas fa-heart mr-2"></i> Matches
                </a>

                <a class="navbar-item" href="index.php?controller=search&action=index">
                    <i class="fas fa-search mr-2"></i> Procurar
                </a>
                <a class="navbar-item" href="index.php?controller=browse&action=index">
                    <i class="fas fa-users mr-2"></i> Utilizadores
                </a>

                <div class="navbar-dropdown is-right is_mobile">

                <?php if (!empty($_SESSION['user_id']) && $notificacaoLikes > 0): ?>
                    <a class="navbar-item" href="index.php?controller=like&action=received">
                        <span class="icon"><i class="fas fa-bell"></i></span>
                        <span class="ml-2">Notificações</span>
                        <span class="tag is-danger is-rounded ml-2"><?= $notificacaoLikes ?></span>
                    </a>
                <?php endif; ?>



                    <a class="navbar-item" href="index.php?controller=profile&action=index">
                        <i class="fas fa-user mr-2"></i>  Meu Perfil
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
                <?php if (!empty($_SESSION['user_id']) && $notificacaoLikes > 0): ?>
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a href="index.php?controller=like&action=received" class="navbar-link">
                            <span class="icon">
                                <i class="fas fa-bell"></i>
                            </span>
                            <?php if ($notificacaoLikes > 0): ?>
                                <span class="tag is-danger is-rounded ml-1"><?= $notificacaoLikes ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="navbar-dropdown is-right">
                            <a href="index.php?controller=like&action=received" class="navbar-item">
                                Ver quem gostou de ti
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

    <?php if (!empty($_SESSION['user_id'])): ?>
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
    <?php endif; ?>
</div>

        <?php endif; ?>
    </div>
</nav>

<section class="section">
    <div class="container">
