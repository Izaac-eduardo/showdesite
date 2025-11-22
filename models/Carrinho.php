<?php  
class Carrinho  {


private $pdo;
public function __construct(PDO $pdo) {
    $this->pdo = $pdo;

}
public function salvar($dados) {
    try {
        $email = trim($dados['email'] ?? '');
        $nome = trim($dados['nome'] ?? '');
        $senhaRaw = $dados['senha'] ?? '';

        if ($email === '' || $nome === '' || $senhaRaw === '') {
            return 0; // dados inválidos
        }

        // Verifica se já existe cliente com o e-mail
        $sqlVerifica = "SELECT id FROM cliente WHERE email = :email";
        $consultaVerifica = $this->pdo->prepare($sqlVerifica);
        $consultaVerifica->bindValue(':email', $email);
        $consultaVerifica->execute();
        $dadosVerifica = $consultaVerifica->fetch(PDO::FETCH_OBJ);

        if (!empty($dadosVerifica->id)) {
            return 2; // já existe
        }

        // Insere novo cliente
        $senha = password_hash($senhaRaw, PASSWORD_BCRYPT);
        $sqlCliente = "INSERT INTO cliente (nome, email, senha) VALUES (:nome, :email, :senha)";
        $consultaCliente = $this->pdo->prepare($sqlCliente);
        $consultaCliente->bindValue(':nome', $nome);
        $consultaCliente->bindValue(':email', $email);
        $consultaCliente->bindValue(':senha', $senha);
        $ok = $consultaCliente->execute();

        return $ok ? 1 : 0;
    } catch (Exception $e) {
        return 0;
    }
}

public function logar($email){
    $sql = "SELECT * FROM cliente WHERE email = :email LIMIT 1" ;

    $consulta = $this->pdo->prepare($sql);
    $consulta->bindValue(":email",$email);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    return $dados;
} 
public function salvarPedido($preference_id) {
    // Use nomes de colunas explicitamente para evitar mismatch com a estrutura da tabela
    $sqlPedido = "INSERT INTO pedido VALUES (null, :cliente_id, NOW(), :preference_id)";
    $consulta = $this->pdo->prepare($sqlPedido);
    $consulta->bindValue(":cliente_id", $_SESSION["cliente"]["id"] );
    $consulta->bindValue(":preference_id", $preference_id);

    if ($consulta->execute()) {

        $pedido_id = $this->pdo->lastInsertId();

        foreach ($_SESSION["carrinho"] as $dados) {
            // Use nomes de colunas explicitamente também
            $sqlItem = "INSERT INTO item (pedido_id, produto_id, qtde, valor) VALUES (:pedido_id, :produto_id, :qtde, :valor)";
            $consultaItem = $this->pdo->prepare($sqlItem);
            $consultaItem->bindValue(":pedido_id", $pedido_id);
            $consultaItem->bindValue(":produto_id", $dados["id"]);
            $consultaItem->bindValue(":qtde", $dados["qtde"]);
            $consultaItem->bindValue(":valor", $dados["valor"]);
            if (!$consultaItem->execute()) 
                // se falhar ao inserir um item, pode-se remover o pedido ou sinalizar erro
                return 0;
            
        }

     
    } else {
        return 0; // Erro ao salvar pedido
    } unset($_SESSION["carrinho"]); return 1;
} 
}
