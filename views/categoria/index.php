<?php
// garante que $id exista
$id = $id ?? null;

$urlCategoria = "http://localhost/geekstore/public/apis/categoria.php" . ($id ? "?id={$id}" : "");
$rawCategoria = @file_get_contents($urlCategoria);
$dadosCategoria = @json_decode($rawCategoria);

// Extrai o nome da categoria tratando várias formas de retorno da API
// Tenta encontrar a categoria pelo id retornado pela API
$nomeCategoria = "Categoria";
if ($dadosCategoria) {
    // se for um objeto representando a categoria
    if (is_object($dadosCategoria) && isset($dadosCategoria->id) && (string)$dadosCategoria->id === (string)$id) {
        $nomeCategoria = $dadosCategoria->descricao ?? $nomeCategoria;
    } elseif (is_object($dadosCategoria) && isset($dadosCategoria->descricao) && !isset($dadosCategoria->id)) {
        // objeto sem id (talvez já seja a descrição)
        $nomeCategoria = $dadosCategoria->descricao;
    } elseif (is_array($dadosCategoria) && count($dadosCategoria) > 0) {
        // procura pelo id dentro do array
        $found = false;
        foreach ($dadosCategoria as $cat) {
            if (is_object($cat) && isset($cat->id) && (string)$cat->id === (string)$id) {
                $nomeCategoria = $cat->descricao ?? $nomeCategoria;
                $found = true;
                break;
            }
            if (is_array($cat) && isset($cat['id']) && (string)$cat['id'] === (string)$id) {
                $nomeCategoria = $cat['descricao'] ?? $nomeCategoria;
                $found = true;
                break;
            }
        }
        // se não encontrou pelo id, usa o primeiro item apenas se $id for vazio
        if (!$found && empty($id)) {
            $first = $dadosCategoria[0];
            if (is_object($first) && isset($first->descricao)) {
                $nomeCategoria = $first->descricao;
            } elseif (is_array($first) && isset($first['descricao'])) {
                $nomeCategoria = $first['descricao'];
            }
        }
    }
}

// Busca produtos da categoria
$urlProduto = "http://localhost/geekstore/public/apis/produto.php?categoria={$id}";
$dadosProduto = @json_decode(@file_get_contents($urlProduto));

?>

<div class="card">
    <div class="card-header">
        <h2>Produtos da categoria: <?= htmlspecialchars($nomeCategoria) ?></h2>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            if (empty($dadosProduto)) {
                ?>
                <div class="col-12">
                    <p>Nenhum produto encontrado para esta categoria.</p>
                </div>
                <?php
            } else {
                foreach ($dadosProduto as $dados) {
                    ?>
                    <div class="col-12 col-md-3">
                        <div class="card text-center p-2 mb-2">
                            <img src="<?= $img ?><?= $dados->imagem ?>" alt="<?= htmlspecialchars($dados->nome) ?>" class="img-fluid">
                            <p>
                                <strong><?= htmlspecialchars($dados->nome) ?></strong>
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
            }
            ?>
        </div>
    </div>
</div>
