<?php require_once VIEWS . 'layout/header.php'; ?>

<h1 class="title">Registar</h1>

<?php if (!empty($errors)): ?>
    <div class="notification is-danger">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (!empty($info)): ?>
    <div class="notification is-success">
        <?= htmlspecialchars($info) ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="field">
        <label class="label">Username</label>
        <div class="control">
            <input class="input" type="text" name="username" required>
        </div>
    </div>

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

    <div class="field">
        <label class="label">Confirmar Password</label>
        <div class="control">
            <input class="input" type="password" name="confirm" required>
        </div>
    </div>

    <div class="control">
        <button class="button is-link" type="submit">Registar</button>
    </div>
</form>

<p class="mt-4">
    <a href="index.php?controller=auth&action=login">Já tens conta? Inicia sessão</a>
</p>

<?php require_once VIEWS . 'layout/footer.php'; ?>
