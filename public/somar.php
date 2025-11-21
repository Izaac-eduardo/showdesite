<?php 
session_start();
$id = $_GET["id"] ?? null;
$qtde = $_GET["qtde"] ?? null;

if(empty($id) || $qtde < 1) {
    echo "Parâmetros inválidos.";


} else {
   $_SESSION["carrinho"][$id]["qtde"] = $qtde;
}
