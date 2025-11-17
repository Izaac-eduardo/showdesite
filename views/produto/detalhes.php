<?php 
$urlProduto = "http://localhost/geekstore/public/apis/produto.php?id={$id}";
$dadosProduto = json_decode(file_get_contents($urlProduto));

?>

<div class="card">
<div class="card-header">
    <?php 
    if(empty($dadosProduto->id)){
        echo "Produto inválido";
    } else {
echo "<h2>{$dadosProduto->nome}</h2>";
    }
    ?>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12 col-md-4">
            <img src="<?= $img ?><?= $dadosProduto->imagem ?>" class="w-100" alt="<?= $dadosProduto->nome ?>">
        </div>
        <div class="col-12 col-md-8">
<?= $dadosProduto->descricao ?>

<p class="float-start valor">
R$ <?= number_format($dadosProduto->valor, 2, ",",".") ?> 
</p>
<p class="float-end">
    <a href="carrinho/adicionar/<?= $dadosProduto->id ?>" class="btn btn-warning">
        <i class="fas fa-shopping-cart"></i> Adicionar ao carrinho
    </a>
</p>
        </div>
    </div>
</div>
</div>