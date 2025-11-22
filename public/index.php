<?php 

session_start();
?>
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
    <link rel="shortcut icon" href="images/geeklogo.ico" type="image/x-icon">
 <script src="js/jquery-3.5.1.min.js"></script>
<script src="js/parsley.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
 
</head>
<body>
    <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index">
                    <img src="images/teste.png" alt="Geek Store" class="img-fluid" style="max-width: 100px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link" href="index">Home</a>
                        </li>
                      <?php 
                      $urlCategoria ="http://localhost/geekstore/public/apis/categoria.php";
                      $dadosCategoria = json_decode(file_get_contents($urlCategoria));
                      
                      foreach($dadosCategoria as $dados) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="categoria/index/<?=  $dados->id ?>">
                                <?= $dados->descricao ?>
                            </a> </li>
                        <?php
                      }
                      ?>
                        <li class="nav-item">
                            <a class="nav-link" href="carrinho">
                                <i class="fas fa-shopping-cart"></i> 
                            </a>
                        </li>
                        <?php 
                        if(isset($_SESSION["cliente"])) {
 ?>
   <li class="nav-item">
                            <a class="nav-link" href="pedidos/index">
                                <i class="fas fa-gift"></i> 
                            </a>
                        </li>
                           <li class="nav-item">
                            <a class="nav-link" href="carrinho/sair">
                               
                                    <i class="fas fa-power-off"></i>
                                
                            </a>
                        </li>



<?php 
                        } else {
                        ?>     <li class="nav-item">
                            <a class="nav-link" href="carrinho/finalizar" >
                               
                                    <i class="fas fa-user"></i>
                                
                            </a>
                        </li>
<?php 
}
?>
                    </ul>
                     </nav>
                     <main class="container">
                        <?php 
                        $param = "index";
                        $img = "http://localhost/geekstore/public/arquivos/";
                        if(isset($_GET["param"])) {
                            $param = explode("/", filter_var(trim($_GET["param"], "/")));}
                            
                            $controller = $param[0] ?? "index";
                            $acao = $param[1] ??"index";
                            $id = $param[2] ?? null;

                            $controller = ucfirst($controller) . "Controller";

                            if(file_exists("../controllers/{$controller}.php")) {
                                require "../controllers/{$controller}.php";
                                 $control = new $controller();
                        $control->$acao($id, $img);
                               
                    } else {
                                require "../views/index/erro.php";
                            }
                
                        
                        ?>
                    </main>

    <!-- Footer preto -->
    <footer class="bg-dark text-white mt-4">
        <div class="container py-4">
            <div class="row">
                <div class="col-12 col-md-4">
                    <h5>Geek Store</h5>
                    <p class="small">Loja fictícia para demonstração. Todos os direitos reservados.</p>
                </div>
                <div class="col-6 col-md-4">
                    <h6>Links</h6>
                    <ul class="list-unstyled small">
                        <li><a href="index" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="produto/index" class="text-white text-decoration-none">Produtos</a></li>
                        <li><a href="carrinho" class="text-white text-decoration-none">Carrinho</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <h6>Contato</h6>
                    <ul class="list-unstyled small">
                        <li>Email: suporte@geekstore.test</li>
                        <li>Telefone: (00) 0000-0000</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center py-2" style="background: rgba(0,0,0,0.2);">
            <small>&copy; <?= date('Y') ?> Geek Store</small>
        </div>
    </footer>

    <!-- Floating promo button -->
    <div id="floatingPromo" class="floating-promo small-text" title="Promoções da Black">
        Promoções da Black
    </div>

    <script>
        // Click handler: show a simple message or redirect
        document.getElementById('floatingPromo').addEventListener('click', function(){
            alert('Aproveite as Promoções da Black! Confira nossos produtos em promoção.');
            // opcional: redirecionar para uma página de promoções
            // window.location.href = 'produto/index';
        });
    </script>

</body>
</html>