<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geek Store</title>
    <base href="http://<?= $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"]?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="
    css/all.min.css">
    <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
 <script src="js/jquery-3.6.0.min.js"></script>
 <script src="js/bootstrap.bundle.min.js"></script>
 
</head>
<?php
// Partial view: conteúdo principal da página inicial.
// Este arquivo é incluído por `public/index.php` que já monta o layout (head, nav e footer).
?>

<section class="py-4 text-center">
    <div class="container">
        <h1 class="display-5">Bem-vindo à Geek Store</h1>
        <p class="lead">Encontre produtos incríveis para sua coleção.</p>
    </div>
</section>

<?php
// Inclui o carousel e a listagem de produtos já existentes em produto/indexall.php
require __DIR__ . '/../produto/indexall.php';
?>