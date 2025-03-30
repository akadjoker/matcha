<?php

require_once  '../../src/bootstrap.php';
require_once  '../../src/router.php';

 

if (empty($_SESSION['user_id'])) 
{
    echo "Utilizador não autenticado.";
    exit;
}

$userModel = new UserModel();
$user = $userModel->findById($_SESSION['user_id']);
$tags = $userModel->getUserTags($_SESSION['user_id']);
$userTagsString = implode(' ', array_map(fn($t) => '#' . $t, $tags));
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Teste de Perfil</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="section">

<h1 class="title">Teste - Dados do Utilizador</h1>

<div class="box">
    <p><strong>ID:</strong> <?= $user['id'] ?></p>
    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($user['bio'] ?? '')) ?></p>
    <p><strong>Tags:</strong> <?= $userTagsString ?></p>

    <?php if (!empty($user['avatar'])): ?>
        <p><strong>Avatar:</strong></p>
        <figure class="image is-128x128">
            <img class="is-rounded" src="/uploads/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar">
        </figure>
    <?php else: ?>
        <p class="has-text-grey">Sem avatar.</p>
    <?php endif; ?>
</div>


</body>
</html>
