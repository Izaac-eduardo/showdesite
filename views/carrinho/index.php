<script src="js/jquery-3.5.1.min.js"></script>
<div class="card">
    <div class="card-header">
        <h1>Carrinho de compras</h1>
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
                        <td><?= $dados["nome"] ?></td>
                        <td>
                            <input type="number" value="<?= $dados["qtde"] ?>" min="1" class="form-control" style="width: 80px;"
                            onblur="somarQuantidade(this.value, <?= $dados["id"]?>)">
                            
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
            <a href="carrinho/finalizar" class="btn btn-success">
                <i class="fa fa-check"></i>
                Finalizar Compra  </a>
        </p>
        <p class="float-end valor">R$ <?= number_format($total, 2, ",", ".") ?></p>
    </div>
</div>
<script>
   somarQuantidade = function(qtde, id) {
        $.get("somar.php", {qtde: qtde, id: id}, function(dados){
            if (dados == "")
                window.location.reload();
            else
                alert(dados);
        })
    }
    </script>