<?php require_once VIEWS . 'layout/header.php'; ?>

<h1 class="title">Login</h1>

<?php if (!empty($error)): ?>
    <div class="notification is-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input class="input" type="email" name="email" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Password</label>
        <div class="control">
            <input class="input" type="password" name="password" required>
        </div>
    </div>

    <div class="control">
        <button class="button is-link" type="submit">Entrar</button>
    </div>
</form>

<p class="mt-4">
    <a href="index.php?controller=auth&action=register">Ainda não tens conta? Regista-te</a>
</p>

<?php require_once VIEWS . 'layout/footer.php'; ?>
