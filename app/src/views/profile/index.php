<?php require_once VIEWS . 'layout/header.php'; ?>

<h1 class="title">O meu perfil</h1>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="notification is-danger">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


<form action="index.php?controller=profile&action=update" method="post" enctype="multipart/form-data">
    <div class="box">
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </div>

    <div class="box">
        <h2 class="subtitle">Foto de perfil</h2>

        <?php if (!empty($user['avatar'])): ?>
            <figure class="image is-128x128 mb-3">
                <img class="is-rounded" src="uploads/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar">
            </figure>
        <?php else: ?>
            <p class="has-text-grey">Ainda não tens foto de perfil.</p>
        <?php endif; ?>

        <div class="file">
            <label class="file-label">
                <input class="file-input" type="file" name="avatar">
                <span class="file-cta">
                    <span class="file-label">Escolher nova foto</span>
                </span>
            </label>
        </div>
    </div>


    

    <div class="box">
        <h2 class="subtitle">Sobre mim (bio)</h2>
        <div class="field">
            <div class="control">
                <textarea class="textarea" name="bio" rows="4"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
            </div>
        </div>
    </div>


    <div class="box">
    <h2 class="subtitle">Informações Pessoais</h2>

    <div class="field">
        <label class="label">Nome próprio</label>
        <div class="control">
            <input class="input" type="text" name="firstname" value="<?= htmlspecialchars($user['firstname'] ?? '') ?>">
        </div>
    </div>

    <div class="field">
        <label class="label">Apelido</label>
        <div class="control">
            <input class="input" type="text" name="lastname" value="<?= htmlspecialchars($user['lastname'] ?? '') ?>">
        </div>
    </div>

    <div class="field">
        <label class="label">Género</label>
        <div class="control">
            <div class="select">
                <select name="gender">
                    <option value="">Seleciona</option>
                    <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Masculino</option>
                    <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Feminino</option>
                    <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Outro</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Orientação Sexual</label>
        <div class="control">
            <div class="select">
                <select name="sexual_orientation">
                    <option value="">Seleciona</option>
                    <option value="straight" <?= $user['sexual_orientation'] === 'straight' ? 'selected' : '' ?>>Heterossexual</option>
                    <option value="gay" <?= $user['sexual_orientation'] === 'gay' ? 'selected' : '' ?>>Homossexual</option>
                    <option value="bi" <?= $user['sexual_orientation'] === 'bi' ? 'selected' : '' ?>>Bissexual</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Data de nascimento</label>
        <div class="control">
            <input class="input" type="date" name="birthdate" value="<?= htmlspecialchars($user['birthdate'] ?? '') ?>">
        </div>
    </div>

    <div class="field">
        <label class="label">Localização</label>
        <div class="control">
            <input class="input" type="text" name="location" value="<?= htmlspecialchars($user['location'] ?? '') ?>">
        </div>
    </div>
</div>

    <div class="box">
        <h2 class="subtitle">Interesses (#tags)</h2>
        <div class="field">
            <div class="control">
                <input class="input" type="text" name="tags" value="<?= htmlspecialchars($userTagsString ?? '') ?>" placeholder="#música #desporto #filmes">
            </div>
            <p class="help">Separa por espaços. Ex: <code>#música #arte</code></p>
        </div>
    </div>

    
    <div class="field is-grouped mt-4">
        <div class="control">
            <button class="button is-primary" type="submit">Guardar alterações</button>
        </div>
        <div class="control">
            <a href="index.php" class="button is-light">Cancelar</a>
        </div>
    </div>
</form>

<?php require_once VIEWS . 'layout/footer.php'; ?>
