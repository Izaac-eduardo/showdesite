<?php 
// Corrige URL da API (remover duplicação 'geekstore') e trata falhas de request/JSON
$urlProduto = "http://localhost/geekstore/public/apis/produto.php?id={$id}";
$response = @file_get_contents($urlProduto);
$dadosProduto = null;
if($response !== false){
    $dadosProduto = json_decode($response);
}

?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header" style="padding: 1.5rem;">
            <?php 
            if(empty($dadosProduto) || empty($dadosProduto->id)){
                echo '<h2 style="color: #f44336; margin: 0;"><i class="fas fa-exclamation-triangle"></i> Produto inválido</h2>';
            } else {
                echo '<h1 style="color: #a78bfa; margin: 0; font-size: 2rem;">' . htmlspecialchars($dadosProduto->nome) . '</h1>';
            }
            ?>
        </div>

        <div class="card-body">
            <div class="row" style="display: flex; gap: 2rem;">
                <!-- Imagem do Produto -->
                <div style="flex: 1; min-width: 300px;">
                    <div style="background: rgba(124, 58, 237, 0.1); border-radius: 15px; padding: 1rem; overflow: hidden; border: 1px solid rgba(124, 58, 237, 0.3);">
                        <?php if(!empty($dadosProduto) && !empty($dadosProduto->imagem)): ?>
                        <img src="<?= $img ?><?= $dadosProduto->imagem ?>" class="w-100" alt="<?= htmlspecialchars($dadosProduto->nome) ?>" style="border-radius: 10px; object-fit: cover; max-height: 500px;">
                        <?php else: ?>
                        <img src="images/erro.png" class="w-100" alt="Imagem indisponível" style="border-radius: 10px;">
                        <?php endif; ?>
                    </div>

                    <!-- Informações de Estoque -->
                    <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(76, 175, 80, 0.1); border-radius: 10px; border: 1px solid rgba(76, 175, 80, 0.3);">
                        <p style="margin-bottom: 0.5rem; color: #888; font-size: 0.9rem;"><i class="fas fa-box"></i> Disponibilidade:</p>
                        <p style="margin: 0; color: #4caf50; font-weight: 700; font-size: 1.2rem;">Em Estoque</p>
                    </div>
                </div>

                <!-- Detalhes do Produto à Direita -->
                <div style="flex: 1; min-width: 300px;">
                    <?php if(!empty($dadosProduto) && !empty($dadosProduto->id)): ?>
                    
                    <!-- Descrição -->
                    <div style="background: rgba(30, 30, 50, 0.5); padding: 1.5rem; border-radius: 10px; border: 1px solid rgba(124, 58, 237, 0.2); margin-bottom: 2rem;">
                        <h3 style="color: #a78bfa; font-size: 1.2rem; margin-bottom: 1rem;"><i class="fas fa-info-circle"></i> Descrição</h3>
                        <div style="color: #bbb; line-height: 1.8; font-size: 0.95rem;">
                            <?= $dadosProduto->descricao ?>
                        </div>
                    </div>

                    <!-- Preço e Ações -->
                    <div style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(99, 102, 241, 0.1)); padding: 2rem; border-radius: 15px; border: 2px solid rgba(124, 58, 237, 0.3); margin-bottom: 2rem;">
                        <p style="margin: 0; color: #888; font-size: 0.95rem; margin-bottom: 0.5rem;">PREÇO:</p>
                        <h2 style="color: #a78bfa; font-size: 2.5rem; font-weight: 700; margin: 0.5rem 0 1.5rem 0;">
                            R$ <?= number_format($dadosProduto->valor, 2, ",", ".") ?>
                        </h2>
                        
                        <div class="d-grid gap-2" style="margin-top: 1.5rem;">
                            <a href="carrinho/adicionar/<?= $dadosProduto->id ?>" class="btn btn-success btn-lg" style="font-weight: 600; padding: 0.8rem 1.5rem; border-radius: 8px;">
                                <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                            </a>
                            <a href="index" class="btn btn-secondary btn-lg" style="font-weight: 600; padding: 0.8rem 1.5rem; border-radius: 8px;">
                                <i class="fas fa-arrow-left"></i> Voltar aos Produtos
                            </a>
                        </div>
                    </div>

                    <!-- Características Adicionais -->
                    <div style="background: rgba(100, 200, 255, 0.1); padding: 1.5rem; border-radius: 10px; border: 1px solid rgba(100, 200, 255, 0.3);">
                        <h4 style="color: #64c8ff; margin-bottom: 1rem; font-weight: 600;"><i class="fas fa-check-circle"></i> Características</h4>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 0.5rem 0; color: #bbb;"><i class="fas fa-star" style="color: #ffb300; margin-right: 0.5rem;"></i> Produto original e autêntico</li>
                            <li style="padding: 0.5rem 0; color: #bbb;"><i class="fas fa-check" style="color: #4caf50; margin-right: 0.5rem;"></i> Entrega rápida e segura</li>
                            <li style="padding: 0.5rem 0; color: #bbb;"><i class="fas fa-shield-alt" style="color: #64c8ff; margin-right: 0.5rem;"></i> Garantia de satisfação</li>
                            <li style="padding: 0.5rem 0; color: #bbb;"><i class="fas fa-undo" style="color: #ff6b6b; margin-right: 0.5rem;"></i> Devolução sem complicações</li>
                        </ul>
                    </div>

                    <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation"></i> Detalhes indisponíveis para este produto. <a href="produto/index">Voltar para produtos</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
