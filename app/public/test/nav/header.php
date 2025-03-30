<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Navbar Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulmaswatch@0.8.1/darkly/bulmaswatch.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        .avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        @media (min-width: 768px) {
            .navbar .navbar-item.is-hidden-tablet img.avatar-small {
                display: none !important;
            }
        }

        @media (max-width: 767px) {
            .navbar-end.is-hidden-mobile {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="#">
            <strong>Matcha</strong>
        </a>

        <!-- Avatar para mobile -->
        <a class="navbar-item is-hidden-tablet" href="#">
            <img src="https://i.pravatar.cc/32" alt="Avatar" class="avatar-small">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navMenu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navMenu" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="#">Home</a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item has-dropdown dropdown-user">
                <a class="navbar-link" id="avatarDropdown">
                    <img src="https://i.pravatar.cc/32" class="avatar-small" />
                    <span>Djoker</span>
                </a>

                <div class="navbar-dropdown is-right">
                    <a class="navbar-item">Perfil</a>
                    <a class="navbar-item">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.navbar-burger');
    const menu = document.getElementById(burger.dataset.target);

    if (burger && menu) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    }

    const dropdown = document.querySelector('.dropdown-user');
    const toggle = document.getElementById('avatarDropdown');

    if (dropdown && toggle) {
        toggle.addEventListener('click', e => {
            e.preventDefault();
            dropdown.classList.toggle('is-active');
        });
    }
});
</script>
