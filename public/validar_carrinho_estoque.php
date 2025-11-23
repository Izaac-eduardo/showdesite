<?php
session_start();
header('Content-Type: application/json');

require "../config/Conexao.php";

try {
    $input = file_get_contents('php://input');
    
    // Tenta usar POST data diretamente
    if (!isset($_POST['carrinho'])) {
        // Se vier via input stream (JSON), faz parse
        if (!empty($input)) {
            parse_str($input, $_POST);
        }
    }
    
    if (!isset($_POST['carrinho'])) {
        echo json_encode(['ok' => false, 'problemas' => [], 'erro' => 'Carrinho não fornecido']);
        exit;
    }

    $carrinhoJson = $_POST['carrinho'];
    $carrinho = json_decode($carrinhoJson, true);
    
    if (!is_array($carrinho)) {
        echo json_encode(['ok' => false, 'problemas' => [], 'erro' => 'Formato inválido']);
        exit;
    }

    $db = new Conexao();
    $pdo = $db->conectar();
    
    $problemas = [];
    $ok = true;

    foreach ($carrinho as $item) {
        $produtoId = (int)$item['id'];
        $qtdeSolicitada = (int)$item['qtde'];
        $nomeProduto = $item['nome'];
        
        $sql = "SELECT estoque FROM produto WHERE id = :id AND ativo = 'S' LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindValue(':id', $produtoId);
        $consulta->execute();
        $produto = $consulta->fetch(PDO::FETCH_OBJ);
        
        if (!$produto) {
            $ok = false;
            $problemas[] = [
                'nome' => $nomeProduto,
                'qtde' => $qtdeSolicitada,
                'estoque' => 0,
                'mensagem' => 'Produto não encontrado'
            ];
            continue;
        }
        
        $estoqueAtual = (int)$produto->estoque;
        
        if ($estoqueAtual < $qtdeSolicitada) {
            $ok = false;
            $problemas[] = [
                'nome' => $nomeProduto,
                'qtde' => $qtdeSolicitada,
                'estoque' => $estoqueAtual,
                'mensagem' => 'Estoque insuficiente'
            ];
        }
    }
    
    echo json_encode([
        'ok' => $ok,
        'problemas' => $problemas
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'ok' => false,
        'problemas' => [],
        'erro' => $e->getMessage()
    ]);
}
?>
