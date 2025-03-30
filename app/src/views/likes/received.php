<?php require_once VIEWS . 'layout/header.php'; ?>

<h1 class="title">💗 Pessoas que gostaram de ti</h1>

<?php if (empty($filtered)): ?>
    <p>Ninguém gostou de ti ainda... dá uns likes 😅</p>
<?php else: ?>
    <div class="columns is-multiline">
        <?php foreach ($filtered as $user): 
            $avatar = !empty($user['avatar']) ? 'uploads/' . htmlspecialchars($user['avatar']) : '/images/default.png';
        ?>
            <div class="column is-one-quarter">
                <div class="card box-hover">
                    <div class="card-image has-text-centered">
                        <figure class="image is-96x96 is-inline-block mt-4">
                            <img class="is-rounded" src="<?= $avatar ?>" alt="avatar">
                        </figure>
                    </div>
                    <div class="card-content has-text-centered">
                        <p><strong><?= htmlspecialchars($user['username']) ?></strong></p>
                        <a href="index.php?controller=profile&action=view&id=<?= $user['id'] ?>" class="button is-small is-primary mt-2">Ver perfil</a>
                        <a href="index.php?controller=profile&action=like&id=<?= $user['id'] ?>" class="button is-small is-link mt-1">💖 Gostar também</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once VIEWS . 'layout/footer.php'; ?>
