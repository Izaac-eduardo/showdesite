<?php
// Mostra apenas os produtos marcados como "destaque" pela API.
// Esta view é uma variação de `indexall.php` que filtra itens antes de renderizar.

?>

<div class="card">
    <div class="card-header">
        <h2>Produtos em Destaque</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            $urlProduto = "http://localhost/geekstore/public/apis/produto.php";
            $dadosProduto = @json_decode(@file_get_contents($urlProduto));

            $mostrou = 0;
            if ($dadosProduto && is_array($dadosProduto)) {
                foreach ($dadosProduto as $dados) {
                    $exibir = false;

                    // Checagens flexíveis para possíveis nomes de campo de destaque
                    if (isset($dados->destaque) && ($dados->destaque === true || $dados->destaque === 1 || $dados->destaque === '1')) $exibir = true;
                    if (isset($dados->em_destaque) && ($dados->em_destaque === true || $dados->em_destaque === 1 || $dados->em_destaque === '1')) $exibir = true;
                    if (isset($dados->featured) && ($dados->featured === true || $dados->featured === 1 || $dados->featured === '1')) $exibir = true;
                    if (isset($dados->destacado) && ($dados->destacado === true || $dados->destacado === 1 || $dados->destacado === '1')) $exibir = true;

                    if (!$exibir) continue;

                    $mostrou++;
                    ?>
                    <div class="col-12 col-md-3">
                        <div class="card text-center p-2 mb-2">
                            <img src="<?= isset($img) ? $img : '' ?><?= isset($dados->imagem) ? $dados->imagem : '' ?>" alt="<?= isset($dados->nome) ? $dados->nome : '' ?>" class="img-fluid">
                            <p class="mt-3">
                                <strong><?= isset($dados->nome) ? $dados->nome : '' ?></strong>
                            </p>
                            <p>
                                <a href="produto/detalhes/<?= isset($dados->id) ? $dados->id : '' ?>" class="btn btn-dark">
                                    <i class="fas fa-search"></i> Detalhes do produto
                                </a>
                            </p>
                        </div>
                    </div>
                    <?php
                }
            }

            if ($mostrou === 0) {
                ?>
                <div class="col-12">
                    <div class="alert alert-info">No momento não há produtos em destaque.</div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
