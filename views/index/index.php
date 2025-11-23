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

<?php
// Partial view: conteúdo principal da página inicial.
// Este arquivo é incluído por `public/index.php` que já monta o layout (head, nav e footer).
?>

<!-- Hero Section -->
<section class="hero-section py-3" style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0a0a0a 100%); position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 20% 50%, rgba(167, 139, 250, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(167, 139, 250, 0.05) 0%, transparent 50%); z-index: 0;"></div>
    
    <div class="container py-5" style="position: relative; z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3" style="color: #e8e8e8;">
                    Bem-vindo ao 
                    <span style="color: #a78bfa; animation: glow 2s ease-in-out infinite;">Geek Store</span>
                </h1>
                <p class="lead mb-4" style="color: #999; font-size: 1.1rem;">
                    Descubra os melhores produtos geek, games, eletrônicos e muito mais com qualidade garantida e preços incríveis.
                </p>
            </div>
            <div class="col-lg-4 text-center" style="animation: float 4s ease-in-out infinite;">
                <div style="font-size: 6rem; animation: float 3s ease-in-out infinite; color: #a78bfa;">
                    <i class="fas fa-gamepad"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Produtos em Destaque -->
<section id="destaques" class="py-5" style="background: #0a0a0a;">
    <div class="container">
        
       
        <div class="row">
            <?php
            // Inclui o carousel e a listagem de produtos já existentes em produto/indexall.php
            require __DIR__ . '/../produto/indexall.php';
            ?>
        </div>
    </div>
</section>