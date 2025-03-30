<?php require_once VIEWS . 'layout/header.php'; ?>

<h1 class="title">Explorar Utilizadores</h1>

<div class="columns is-multiline">
    <?php foreach ($users as $user): 
        
        $avatar = !empty($user['avatar']) 
            ? 'uploads/' . htmlspecialchars($user['avatar']) 
            : '/images/default.png';
    ?>
        <div class="column is-one-quarter">
            <div class="card box-hover">
                <div class="card-image has-text-centered">
                    <figure class="image is-128x128 is-inline-block mt-4">
                        <img class="is-rounded" src="<?= $avatar ?>" alt="Avatar">
                    </figure>
                </div>

                <div class="card-content has-text-centered">
                    <p><strong><?= htmlspecialchars($user['username']) ?></strong></p>
                    <p><?= htmlspecialchars($user['location'] ?? 'Sem localização') ?></p>
                    <p class="is-size-7">
                        <?= htmlspecialchars(substr($user['bio'] ?? '', 0, 60)) ?>
                        <?= (isset($user['bio']) && strlen($user['bio']) > 60) ? '...' : '' ?>
                    </p>

                    <a href="index.php?controller=profile&action=view&id=<?= (int)$user['id'] ?>" class="button is-small is-primary mt-2">Ver perfil</a>

                    <?php if (!$user['already_liked']): ?>
                        <a href="index.php?controller=profile&action=like&id=<?= (int)$user['id'] ?>" class="button is-small is-link mt-1">💖 Gostar</a>
                    <?php else: ?>
                        <button class="button is-small is-light mt-1" disabled>💖 Já gostaste</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once VIEWS . 'layout/footer.php'; ?>
