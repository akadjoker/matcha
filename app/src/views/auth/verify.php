<?php require_once VIEWS . 'layout/header.php'; ?>

<h1 class="title">Verificação de Conta</h1>

<div class="notification is-info">
    <?= htmlspecialchars($message ?? 'Estado da verificação não definido.') ?>
</div>

<p class="mt-4">
    <a href="index.php?controller=auth&action=login">Voltar ao Login</a>
</p>

<?php require_once VIEWS . 'layout/footer.php'; ?>
