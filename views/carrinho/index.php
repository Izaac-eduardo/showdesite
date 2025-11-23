<script src="js/jquery-3.5.1.min.js"></script>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 style="margin: 0; color: #a78bfa;"> Carrinho de Compras</h1>
                <?php 
                if(isset($_SESSION["cliente"]["id"])){
                    echo '<div style="text-align: right;">
                        <p style="margin-bottom: 0.5rem; color: #aaa;">Bem-vindo, <strong style="color: #a78bfa;">' . $_SESSION["cliente"]["nome"] . '</strong></p>
                        <a href="carrinho/sair" class="btn btn-sm btn-danger"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </div>';
                }
                ?>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr style="border-bottom: 2px solid #a78bfa;">
                            <th style="color: #000;"> </th>
                            <th style="color: #000;"> </th>
                            <th style="color: #000; text-align: center;"> Quantidade</th>
                            <th style="color: #000; text-align: right;"> Valor Unit.</th>
                            <th style="color: #000; text-align: right;"> Subtotal</th>
                            <th style="color: #000; text-align: center;"> Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        if (!empty($_SESSION["carrinho"])) {
                        $index = 0;
                        foreach ($_SESSION["carrinho"] as $dados) {
                            $total = $total + $dados["qtde"] * $dados["valor"];
                            $index++;
                            ?>
                            <tr style="vertical-align: middle;">
                                <td>
                                    <img src="<?=$img  ?><?= $dados["imagem"] ?>" alt="<?= $dados["nome"] ?>" style="width: 100px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(124, 58, 237, 0.3); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                </td>
                                <td>
                                    <div>
                                        <strong style="color: #000; font-size: 1.05rem;"><?= $dados["nome"] ?></strong>
                                        <div class="mt-2">
                                           
                                            <div class="estoque-info " id="estoque-<?= $dados["id"] ?>" style="margin-top: 5px; font-weight: bold; color"></div>
                                        </div>
                                    </div>
                                    <small class="text-warning  mt-2 d-block qtde-aviso-<?= $dados["id"] ?>"></small>
                                </td>
                                <td style="text-align: center;">
                                    <input type="number" value="<?= $dados["qtde"] ?>" min="1" class="form-control" style="width: 70px; margin: auto;"
                                    onblur="somarQuantidade(this.value, <?= $dados["id"]?>)">
                                </td>
                                <td style="text-align: right; color: #000; font-weight: 600;">R$ <?= number_format($dados["valor"], 2, ",", ".") ?></td>
                                <td style="text-align: right; color: #000; font-weight: 700; font-size: 1.1rem;">R$ <?= number_format($dados["qtde"] * $dados["valor"], 2, ",", ".") ?></td>
                                <td style="text-align: center;">
                                    <a href="carrinho/excluir/<?= $dados["id"] ?>" class="btn btn-sm btn-danger" title="Remover do carrinho">
                                        <i class="fas fa-trash-alt"></i> Remover
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        } else {
                            echo '<tr><td colspan="6" style="text-align: center; padding: 2rem; color: #b3b2b2ff;">
                                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                                <p>Seu carrinho está vazio. Volte para a loja e escolha seus produtos!</p>
                                <a href="index" class="btn btn-primary mt-3"><i class="fas fa-shopping-bag"></i> Continuar Comprando</a>
                            </td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer" style="background: rgba(124, 58, 237, 0.05); border-top: 2px solid rgba(124, 58, 237, 0.3);">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 1rem;">
                <div class="btn-group" role="group">
                    <a href="carrinho/limpar" class="btn btn-warning" title="Limpar todo o carrinho">
                        <i class="fas fa-trash"></i> Limpar Carrinho
                    </a>
                    <a href="index" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Continuar Comprando
                    </a>
                </div>
                <div style="text-align: right;">
                    <p style="margin-bottom: 0.5rem; color: #aaa; font-size: 0.9rem;">TOTAL:</p>
                    <p class="valor" style="margin: 0; font-size: 1.8rem;">R$ <?= number_format($total, 2, ",", ".") ?></p>
                </div>
                <div>
                    <a href="carrinho/finalizar" class="btn btn-success btn-lg" onclick="return validarEstoqueAntesFinalizar();" style="padding: 0.75rem 2rem;">
                        <i class="fas fa-lock"></i> Finalizar Compra
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Função para verificar estoque de um produto via AJAX
    verificarEstoque = function(produtoId) {
        $.ajax({
            url: 'api_estoque.php',
            type: 'GET',
            data: { produto_id: produtoId },
            dataType: 'json',
            success: function(response) {
                const infoDiv = $('#estoque-' + produtoId);
                const avisoDiv = $('.qtde-aviso-' + produtoId);
                
                if (response.status === 'disponivel') {
                    infoDiv.html('<span class="badge bg-success">Estoque: ' + response.estoque + ' unidades</span>');
                    avisoDiv.html('');
                } else if (response.status === 'indisponivel') {
                    infoDiv.html('<span class="badge bg-danger">Sem estoque</span>');
                    avisoDiv.html('<strong>⚠️ Produto indisponível para compra</strong>');
                } else {
                    infoDiv.html('<span class="badge bg-warning">Estoque: ' + response.estoque + '</span>');
                }
            },
            error: function() {
                $('#estoque-' + produtoId).html('<span class="badge bg-secondary">Erro ao verificar</span>');
            }
        });
    };

    // Verifica estoque ao carregar a página
    $(document).ready(function() {
        <?php 
        if (!empty($_SESSION["carrinho"])) {
            foreach ($_SESSION["carrinho"] as $dados) {
                echo "verificarEstoque(" . $dados["id"] . ");";
            }
        }
        ?>
    });

    // Função para atualizar quantidade
    somarQuantidade = function(qtde, id) {
        $.get("somar.php", {qtde: qtde, id: id}, function(dados){
            if (dados == "")
                window.location.reload();
            else
                alert(dados);
        })
    };

    // Função para validar estoque antes de finalizar
    validarEstoqueAntesFinalizar = function() {
        <?php 
        if (!empty($_SESSION["carrinho"])) {
            ?>
            const carrinhoItems = <?php echo json_encode(array_map(function($item) { 
                return ['id' => $item["id"], 'qtde' => $item["qtde"], 'nome' => $item["nome"]]; 
            }, $_SESSION["carrinho"])); ?>;
            
            let temProblema = false;
            let mensagemProblema = "⚠️ Problemas de estoque detectados:\n\n";
            
            // Verifica cada item via AJAX
            $.ajax({
                type: 'POST',
                url: 'validar_carrinho_estoque.php',
                data: { carrinho: JSON.stringify(carrinhoItems) },
                dataType: 'json',
                async: false,
                success: function(response) {
                    if (!response.ok) {
                        temProblema = true;
                        response.problemas.forEach(function(prob) {
                            mensagemProblema += "• " + prob.nome + "\n";
                            mensagemProblema += "  Solicitado: " + prob.qtde + " | Disponível: " + prob.estoque + "\n\n";
                        });
                    }
                }
            });
            
            if (temProblema) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Estoque Insuficiente',
                        html: '<pre style="text-align: left;">' + mensagemProblema + '</pre>',
                        confirmButtonText: 'Ajustar Carrinho'
                    });
                } else {
                    alert(mensagemProblema);
                }
                return false;
            }
            <?php 
        }
        ?>
        return true;
    };
</script>