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

}
