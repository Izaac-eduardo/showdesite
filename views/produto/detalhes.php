<?php 
// Corrige URL da API (remover duplicação 'geekstore') e trata falhas de request/JSON
$urlProduto = "http://localhost/geekstore/public/apis/produto.php?id={$id}";
$response = @file_get_contents($urlProduto);
$dadosProduto = null;
if($response !== false){
    $dadosProduto = json_decode($response);
}

?>

<div class="card">
<div class="card-header">
    <?php 
    if(empty($dadosProduto) || empty($dadosProduto->id)){
        echo "Produto inválido";
    } else {
        echo "<h2>{$dadosProduto->nome}</h2>";
    }
    ?>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12 col-md-4">
            <?php if(!empty($dadosProduto) && !empty($dadosProduto->imagem)): ?>
            <img src="<?= $img ?><?= $dadosProduto->imagem ?>" class="w-100" alt="<?= $dadosProduto->nome ?>">
            <?php else: ?>
            <img src="images/erro.png" class="w-100" alt="Imagem indisponível">
            <?php endif; ?>
        </div>
        <div class="col-12 col-md-8">
<?php if(!empty($dadosProduto) && !empty($dadosProduto->id)): ?>
<?= $dadosProduto->descricao ?>

<p class="float-start valor">
R$ <?= number_format($dadosProduto->valor, 2, ",", ".") ?> 
</p>
<p class="float-end">
    <a href="carrinho/adicionar/<?= $dadosProduto->id ?>" class="btn btn-warning">
        <i class="fas fa-shopping-cart"></i> Adicionar ao carrinho
    </a>
</p>
<?php else: ?>
<p>Detalhes indisponíveis para este produto.</p>
<?php endif; ?>
        </div>
    </div>
</div>
</div>
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