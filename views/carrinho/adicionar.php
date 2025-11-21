<?php 

$urlProduto = "http://localhost/geekstore/public/apis/produto.php?id={$id}";
$response = @file_get_contents($urlProduto);
$dadosProduto = null;

if($response !== false) {
    $dadosProduto = json_decode($response);
}

if(!empty($dadosProduto) && !empty($dadosProduto->id)){
    // Inicializar carrinho se não existir
    if(!isset($_SESSION["carrinho"])) {
        $_SESSION["carrinho"] = array();
    }

    $qtde = $_SESSION["carrinho"][$id]["qtde"] ?? 0;
    $qtde++;
    
    $_SESSION["carrinho"][$id] = array(
        "id" => $dadosProduto->id, 
        "nome" => $dadosProduto->nome,
        "qtde" => $qtde,
        "valor" => $dadosProduto->valor,
        "imagem" => $dadosProduto->imagem);

     echo "<script>location.href='carrinho'</script>";
    

    
    
    
} else {
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<h4 class='alert-heading'>Erro!</h4>";
    echo "<p>Produto inválido ou indisponível.</p>";
    echo "</div>";
}

?>