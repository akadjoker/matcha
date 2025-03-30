<?php

require_once  '../../src/bootstrap.php';
require_once  '../../src/router.php';


try
{
    $pdo = Database::getInstance();
    $stmt = $pdo->query("SELECT * FROM users");

    echo "<h3>Utilizadores:</h3>";
    foreach ($stmt as $row)
    {
        echo $row['username'] . "<br>";
    }
}
catch (Exception $e)
{
    echo "❌ Erro na base de dados: " . $e->getMessage();
}
