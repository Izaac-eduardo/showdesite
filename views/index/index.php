<div class="card">
    <div class="card-header">
        <h2>Produtos em destaque</h2>
    </div>
    <div class="card-body">
<div class="row">
<?php 
$urlProduto ="http://localhost/geekstore/public/apis/destaque.php";
$dadosProduto = json_decode(file_get_contents($urlProduto));
foreach ($dadosProduto as $dados){
    
    ?>
    <div class="col-12 col-md-3">
        <div class="card text-center p-2 mb-2">
            <img src="<?= $img ?><?= $dados->imagem ?>" alt="<?= $dados->nome ?>">
            <p>
                <strong><?=$dados->nome?></strong>
            </p>
            <p>
                <a href="produto/detalhes/<?= $dados->id ?>" class="btn btn-dark">
                    <i class="fas fa-search"></i> Detalhes do produto
                </a>
            </p>
        </div>
    </div>
    <?php
}
?>

</div>
<p class="text-center">
<a href="produto/index" class="btn btn-dark btn-lg">
    <i class="fas fa-search"></i>
    Todos os produtos
</a>
</p>
    </div>
</div>