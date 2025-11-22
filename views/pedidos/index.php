<div class="card">
    <div class="card-header">
        <h1>Seus pedidos</h1>
    </div>
    <div class="card-body">
        <?php 
        $dadosPedido = $this->pedidos->getPedidos();
        foreach($dadosPedido as $dados) {
?> <p>
<strong>Pedido:  <?= $dados->id ?></strong> - 
Data: <?= $dados->dt ?>
</p>
<table class="table table-bordered table-striped">
<?php
$itens = $this->pedidos->getItens($dados->id);
foreach($itens as $item) {
    echo "<tr>";
    echo "<td>" . $item->nome . "</td>";
    echo "<td>" . $item->valor . "</td>";
    echo "<td>" . $item->qtde . "</td>";
    echo "</tr>";
}
?>
</table>


<?php

        }?>
    </div>
</div>