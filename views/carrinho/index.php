<script src="js/jquery-3.5.1.min.js"></script>
<div class="card">
    <div class="card-header">
        <h1>Carrinho de compras</h1>

    </div>
    <div class="card-body">
        <?php 
        if(isset($_SESSION["cliente"]["id"])){
            echo "<p>
            Olá, " . $_SESSION["cliente"]["nome"] . "! Você está logado. <a href='carrinho/sair'>Sair</a></p>";
        
        }
        
        
        ?>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>Imagem</td>
                    <td>Nome</td>
                    <td>Quantidade</td>
                    <td>Valor Unitário</td>
                    <td>Subtotal</td>
                    <td>Ações</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                if (!empty($_SESSION["carrinho"])) {
                foreach ($_SESSION["carrinho"] as $dados)
                {$total = $total + $dados["qtde"] * $dados["valor"];
                    ?>
                    <tr>
                        <td><img src="<?=$img  ?><?= $dados["imagem"] ?>" alt="" width="130px"></td>
                        <td>
                            <?= $dados["nome"] ?>
                            <div class="mt-2">
                                <small class="text-muted">Verificando estoque...</small>
                                <div class="estoque-info" id="estoque-<?= $dados["id"] ?>" style="margin-top: 5px; font-weight: bold;"></div>
                            </div>
                        </td>
                        <td>
                            <input type="number" value="<?= $dados["qtde"] ?>" min="1" class="form-control" style="width: 80px;"
                            onblur="somarQuantidade(this.value, <?= $dados["id"]?>)">
                            <small class="text-muted mt-1 d-block qtde-aviso-<?= $dados["id"] ?>"></small>
                        </td>
                        <td>R$ <?= number_format($dados["valor"], 2, ",", ".") ?></td>
                        <td>R$ <?= number_format($dados["qtde"] * $dados["valor"], 2, ",", ".") ?></td>
                        <td>
                            <a href="carrinho/excluir/<?= $dados["id"] ?>" class="btn btn-danger">
                            <i class="fa fas-trash"></i>
                        Excluir</a>
                        </td>
                    </tr>
                    <?php
                }}
                ?>
            </tbody>
        </table>
        <p class="float-start fw-bold">
            <a href="carrinho/limpar" class="btn btn-warning">
                <i class="fa fa-eraser"></i>
                Limpar Carrinho
            </a>
            <a href="carrinho/finalizar" class="btn btn-success" onclick="return validarEstoqueAntesFinalizar();">
                <i class="fa fa-check"></i>
                Finalizar Compra  </a>
        </p>
        <p class="float-end valor">R$ <?= number_format($total, 2, ",", ".") ?></p>
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