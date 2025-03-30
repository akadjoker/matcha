<?php require_once VIEWS . 'layout/header.php'; ?>

<h1 class="title">Procurar Utilizadores</h1>

<form method="get" action="index.php" class="box mb-5">
    <input type="hidden" name="controller" value="search">
    <input type="hidden" name="action" value="index">

    <div class="columns is-multiline">

        <div class="column is-one-third">
            <label class="label">Género</label>
            <div class="select is-fullwidth">
                <select name="gender">
                    <option value="">-- Qualquer --</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
        </div>

        <div class="column is-one-third">
            <label class="label">Orientação Sexual</label>
            <div class="select is-fullwidth">
                <select name="orientation">
                    <option value="">-- Qualquer --</option>
                    <option value="heterossexual">Heterossexual</option>
                    <option value="homossexual">Homossexual</option>
                    <option value="bissexual">Bissexual</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
        </div>

        <div class="column is-one-third">
            <label class="label">Localização</label>
            <input class="input" type="text" name="location" placeholder="Lisboa, Porto...">
        </div>

        <div class="column is-one-third">
            <label class="label">Idade mínima</label>
            <input class="input" type="number" name="min_age" min="18" max="100" placeholder="Ex: 20">
        </div>

        <div class="column is-one-third">
            <label class="label">Idade máxima</label>
            <input class="input" type="number" name="max_age" min="18" max="100" placeholder="Ex: 40">
        </div>

        <div class="column is-full">
        <label class="label">Tags (interesses)</label>
        <div class="tags">
            <?php foreach ($tags as $tag): ?>
                <label class="checkbox mr-3">
                    <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag) ?>">
                    <?= ucfirst(htmlspecialchars($tag)) ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>


    </div>

    <div class="control mt-4">
        <button class="button is-primary">🔍 Procurar</button>
    </div>
</form>

<hr>

<?php if (!empty($users)): ?>
    <div class="columns is-multiline">
        <?php foreach ($users as $user): 
            $avatar = !empty($user['avatar']) ? 'uploads/' . htmlspecialchars($user['avatar']) : '/images/default.png';
        ?>
            <div class="column is-one-quarter">
                <div class="card box-hover">
                    <div class="card-image has-text-centered pt-4">
                        <figure class="image is-96x96 is-inline-block">
                            <img class="is-rounded" src="<?= $avatar ?>" alt="avatar">
                        </figure>
                    </div>
                    <div class="card-content has-text-centered">
                        <p><strong><?= htmlspecialchars($user['username'] ?? '') ?></strong></p>
                        <p><?= htmlspecialchars($user['location'] ?? 'Sem localização') ?></p>
                        <p>
                            <a class="button is-small is-link mt-2" href="index.php?controller=profile&action=view&id=<?= (int)($user['id'] ?? 0) ?>">Ver perfil</a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php elseif ($_GET): ?>
    <p><em>Nenhum utilizador encontrado com esses filtros.</em></p>
<?php endif; ?>

<?php require_once VIEWS . 'layout/footer.php'; ?>
