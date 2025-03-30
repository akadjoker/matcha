<?php

require_once  '../../src/bootstrap.php';
require_once  '../../src/router.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto']))
{
    $uploadDir = PUBLIC_PATH . '/uploads/';
    $fileName = basename($_FILES['foto']['name']);
    $targetPath = $uploadDir . $fileName;

    if (!is_dir($uploadDir))
    {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath))
    {
        echo "✅ Upload feito: <img src='/uploads/$fileName' width='200'>";
    }
    else
    {
        echo "❌ Erro ao mover o ficheiro.";
    }
}

?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="foto">
    <button type="submit">Fazer Upload</button>
</form>
