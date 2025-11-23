<?php
session_start();
header('Content-Type: application/json');

require "../config/Conexao.php";

try {
    if (!isset($_GET['produto_id'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Produto ID não fornecido']);
        exit;
    }

    $produto_id = (int)$_GET['produto_id'];
    
    $db = new Conexao();
    $pdo = $db->conectar();
    
    $sql = "SELECT id, nome, estoque FROM produto WHERE id = :id AND ativo = 'S' LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindValue(':id', $produto_id);
    $consulta->execute();
    $produto = $consulta->fetch(PDO::FETCH_OBJ);
    
    if (!$produto) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Produto não encontrado']);
        exit;
    }
    
    $estoque = (int)$produto->estoque;
    $status = $estoque > 0 ? 'disponivel' : 'indisponivel';
    
    echo json_encode([
        'status' => $status,
        'estoque' => $estoque,
        'produto_id' => $produto_id,
        'produto_nome' => $produto->nome
    ]);
    
} catch (Exception $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
?>
