<!-- Carousel (4 imagens, troca automática a cada 4s) - altura fixa 700px -->
<div class="home-carousel mb-5" style="max-height:450px; overflow:hidden; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3); border: 1px solid rgba(124, 58, 237, 0.3);">
  <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/destaque.png" class="d-block w-100" alt="Slide 1" style="height:600px; object-fit:cover; width:100%;">
        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.5), transparent); padding: 2rem 1rem; color: white;">
        
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/promocao.png" class="d-block w-100" alt="Slide 2" style="height:600px; object-fit:cover; width:100%;">
        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.5), transparent); padding: 2rem 1rem; color: white;">
         
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/oferta especial.png" class="d-block w-100" alt="Slide 3" style="height:600px; object-fit:cover; width:100%;">
        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.5), transparent); padding: 2rem 1rem; color: white;">
        
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/novidades.png" class="d-block w-100" alt="Slide 4" style="height:600px; object-fit:cover; width:100%;">
        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.5), transparent); padding: 2rem 1rem; color: white;">
        
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: drop-shadow(0 0 5px rgba(0,0,0,0.5));"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true" style="filter: drop-shadow(0 0 5px rgba(0,0,0,0.5));"></span>
      <span class="visually-hidden">Próximo</span>
    </button>
  </div>
</div>

 <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="color: #a78bfa; font-size: 2.5rem; margin-bottom: 0.5rem;">
                <i class="fas fa-fire"></i> Destaques Especiais
            </h2>
            <p style="color: #888; font-size: 1.1rem;">Confira nossos produtos mais procurados</p>
            <div style="width: 80px; height: 3px; background: linear-gradient(90deg, transparent, #a78bfa, transparent); margin: 1rem auto;"></div>
        </div>
        

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
  static $index = 0;
  $index++;
  ?>
  <div class="col-12 col-sm-6 col-lg-3 mb-4">
    <div class="produto-card">
      <div style="position: relative; overflow: hidden; height: 250px;">
        <img src="<?= $img ?><?= $dados->imagem ?>" alt="<?= $dados->nome ?>" class="produto-image">
        <?php if ($truthy($dados->destaque)) { ?>
          <div style="position: absolute; top: 10px; right: 10px;">
           
          </div>
        <?php } ?>
      </div>
      
      <div class="produto-info">
        <h4 class="produto-titulo"><?= $dados->nome ?></h4>
        <p class="produto-descricao">
          <?= strlen($dados->descricao) > 80 ? substr(strip_tags($dados->descricao), 0, 80) . '...' : strip_tags($dados->descricao) ?>
        </p>
        
        <div style="margin-top: auto;">
          <div class="produto-preco">R$ <?= number_format($dados->valor, 2, ",", ".") ?></div>
          
          <div class="d-grid gap-2">
            <a href="produto/detalhes/<?= $dados->id ?>" class="btn btn-primary btn-sm">
              <i class="fas fa-eye"></i> Ver Detalhes
            </a>
            <a href="carrinho/adicionar/<?= $dados->id ?>" class="btn btn-success btn-sm">
              <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}

if (!$temDestaque) {
  echo '<div class="col-12"><div class="alert" style="background: rgba(76, 175, 80, 0.1); color: #4caf50; text-align: center; padding: 2rem;"><i class="fas fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>No momento não há produtos em destaque. Volte em breve!</div></div>';
}
?>

</div>