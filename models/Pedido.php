<?php
class Pedido  {


private $pdo;
public function __construct($pdo) {
    $this->pdo = $pdo;

}
public function getPedidos()
{
$sql = "select *, date_format(data, '%d/%m/%Y %H:%i') as dt from pedido where cliente_id = :cliente_id order by data";
$consulta = $this->pdo->prepare($sql);
$consulta->bindParam(":cliente_id", $_SESSION["cliente"]["id"]);
$consulta->execute();

return $consulta->fetchAll(PDO::FETCH_OBJ);
}
public function getItens($pedido) {
    $sql = "select p.nome, i.valor, i.qtde from item i inner join produto p on (p.id = i.produto_id) where i.pedido_id = :pedido_id order by nome";
    $consulta = $this->pdo->prepare($sql);
    $consulta->bindParam(":pedido_id", $pedido);
    $consulta->execute();

    return $consulta->fetchAll(PDO::FETCH_OBJ);
}

}