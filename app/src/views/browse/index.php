<?php require_once VIEWS . 'layout/header.php'; ?>

<h1 class="title">Explorar Utilizadores</h1>

<div class="columns is-multiline">
    <?php foreach ($users as $user): 
        
        // Avatar
        if (empty($user['avatar']))
        {
            $avatar = '/images/default.png';
        }
        else
        {
            $avatar = 'uploads/' . htmlspecialchars($user['avatar']);
        }

        // Género
        $sexo = $user['gender'] ?? 'N/A';

        // Idade
        $idade = 'Idade desconhecida';
        if (!empty($user['birthdate']))
        {
            $nascimento = new DateTime($user['birthdate']);
            $hoje = new DateTime();
            $idade = $hoje->diff($nascimento)->y . ' anos';
        }
    ?>
        <div class="column is-one-quarter">
            <div class="card box-hover">
                <div class="card-image has-text-centered">
                    <figure class="image is-128x128 is-inline-block mt-4">
                        <img class="is-rounded" src="<?= $avatar ?>" alt="Avatar">
                    </figure>
                </div>
                <div class="card-content has-text-centered">
                    <p><strong><?= htmlspecialchars($user['username'] ?? 'Sem nome') ?></strong></p>

                    <p><?= htmlspecialchars(ucfirst($sexo)) ?> | <?= $idade ?></p>
                    
                    <p><?= htmlspecialchars($user['location'] ?? 'Sem localização') ?></p>

                    <p class="is-size-7">
                        <?= htmlspecialchars(substr($user['bio'] ?? '', 0, 60)) ?>
                        <?= isset($user['bio']) && strlen($user['bio']) > 60 ? '...' : '' ?>
                    </p>

                    <a href="index.php?controller=profile&action=view&id=<?= (int)$user['id'] ?>" class="button is-small is-primary mt-3">Ver perfil</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once VIEWS . 'layout/footer.php'; ?>
