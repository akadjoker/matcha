<?php require_once VIEWS . 'layout/header.php'; ?>

<section class="section">
    <div class="container">
        <h1 class="title has-text-centered">
            Perfil de <?= htmlspecialchars($user['username'] ?? 'Desconhecido') ?>
        </h1>

        <div class="columns is-centered">
            <div class="column is-half">
                <div class="card">
                    <div class="card-image has-text-centered pt-4">
                        <?php
                            $avatar = empty($user['avatar'])
                                ? '/images/default.png'
                                : 'uploads/' . htmlspecialchars($user['avatar']);
                        ?>
                        <figure class="image is-128x128 is-inline-block">
                            <img class="is-rounded" src="<?= $avatar ?>" alt="Avatar">
                        </figure>
                    </div>

                    <div class="card-content">
                        <p><strong>Nome:</strong> <?= htmlspecialchars(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '') ?></p>
                        <p><strong>Género:</strong> <?= htmlspecialchars(ucfirst($user['gender'] ?? 'Não definido')) ?></p>
                        <p><strong>Orientação:</strong> <?= htmlspecialchars(ucfirst($user['sexual_orientation'] ?? 'Não definida')) ?></p>

                        <?php
                            $idade = 'Idade desconhecida';
                            if (!empty($user['birthdate'])) {
                                try {
                                    $nascimento = new DateTime($user['birthdate']);
                                    $hoje = new DateTime();
                                    $idade = $hoje->diff($nascimento)->y . ' anos';
                                } catch (Exception $e) {
                                    $idade = 'Erro na data';
                                }
                            }
                        ?>
                        <p><strong>Idade:</strong> <?= $idade ?></p>
                        <p><strong>Localização:</strong> <?= htmlspecialchars($user['location'] ?? 'Não definida') ?></p>

                        <hr>

                        <p><strong>Biografia:</strong><br>
                            <?= nl2br(htmlspecialchars($user['bio'] ?? '')) ?>
                        </p>

                        <?php if (!empty($tags)) : ?>
                            <hr>
                            <p><strong>Tags:</strong></p>
                            <div class="tags">
                                <?php foreach ($tags as $tag): ?>
                                    <span class="tag is-light"><?= htmlspecialchars($tag) ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>


                                <?php if ($isMatch): ?>
                                <div class="has-text-centered mt-4">
                                    <span class="tag is-success is-medium mb-4">
                                        🎉 É um match!
                                    </span>
                                </div>
                            <?php endif; ?>

                            <div class="buttons is-centered">
                                <form action="index.php?controller=profile&action=like&id=<?= (int)$user['id'] ?>" method="post">
                                    <button class="button is-small <?= $hasLiked ? 'is-danger' : 'is-link' ?>" type="submit">
                                        <span class="icon">
                                            <i class="fas <?= $hasLiked ? 'fa-heart-broken' : 'fa-heart' ?>"></i>
                                        </span>
                                        <span><?= $hasLiked ? 'Remover gosto' : 'Gostar' ?></span>
                                    </button>
                                </form>

                                <a href="index.php?controller=message&action=start&id=<?= (int)$user['id'] ?>" class="button is-primary is-small">
                                    <span class="icon"><i class="fas fa-comment-alt"></i></span>
                                    <span>Enviar mensagem</span>
                                </a>
                            </div>

                      

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once VIEWS . 'layout/footer.php'; ?>
