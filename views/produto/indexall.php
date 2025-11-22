<!-- Carousel (4 imagens, troca automática a cada 4s) - altura fixa 700px -->
<div class="home-carousel mb-4" style="max-height:700px; overflow:hidden;">
  <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/destaque.png" class="d-block w-100" alt="Slide 1" style="height:400px; object-fit:cover; width:100%;">
      </div>
      <div class="carousel-item">
        <img src="images/promocao.png" class="d-block w-100" alt="Slide 2" style="height:400px; object-fit:cover; width:100%;">
      </div>
      <div class="carousel-item">
        <img src="images/oferta especial.png" class="d-block w-100" alt="Slide 3" style="height:400px; object-fit:cover; width:100%;">
      </div>
      <div class="carousel-item">
        <img src="images/novidades.png" class="d-block w-100" alt="Slide 4" style="height:400px; object-fit:cover; width:100%;">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Próximo</span>
    </button>
  </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Produtos em destaque!</h2>
    </div>
    <div class="card-body">
<div class="row">
<?php
$urlProduto = "http://localhost/geekstore/public/apis/produto.php";
$dadosProduto = @json_decode(@file_get_contents($urlProduto));

// Normaliza resposta da API para um array de produtos
$produtos = [];
if (is_array($dadosProduto)) {
  $produtos = $dadosProduto;
} elseif (is_object($dadosProduto)) {
  if (!empty($dadosProduto->data) && is_array($dadosProduto->data)) {
    $produtos = $dadosProduto->data;
  } elseif (!empty($dadosProduto->produtos) && is_array($dadosProduto->produtos)) {
    $produtos = $dadosProduto->produtos;
  } else {
    // único objeto -> transformar em array
    $produtos = [$dadosProduto];
  }
}

$temDestaque = false;

$truthy = function($v) {
  if ($v === true || $v === 1 || $v === "1") return true;
  if (is_string($v)) {
    $v = strtolower(trim($v));
    return in_array($v, ['1','true','t','yes','s','sim'], true);
  }
  return false;
};

foreach ($produtos as $dados) {
  if (!isset($dados->destaque) || !$truthy($dados->destaque)) {
    continue; // pula não-destaque
  }
  $temDestaque = true;
  ?>
  <div class="col-12 col-md-3">
    <div class="card text-center p-2 mb-2">
      <img src="<?= $img ?><?= $dados->imagem ?>" alt="<?= $dados->nome ?>" class="img-fluid">
      <p class="mt-3">
        <strong><?= $dados->nome ?></strong>
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

if (!$temDestaque) {
  echo '<div class="col-12"><p class="alert alert-info">No momento não há produtos em destaque.</p></div>';
}
?>

</div>


    </div>
</div>