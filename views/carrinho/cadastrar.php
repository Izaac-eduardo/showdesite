<?php
// Processamento do cadastro: validação simples antes de chamar o model
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    if ($nome === '') {
        $errors[] = 'Digite o nome';
    }
    if ($email === '') {
        $errors[] = 'Digite o email';
    }
    if ($senha === '' || strlen($senha) < 6) {
        $errors[] = 'A senha deve ter no mínimo 6 caracteres';
    }

    if (!empty($errors)) {
        foreach ($errors as $err) {
            echo '<p class="alert alert-danger text-center">' . htmlspecialchars($err) . '</p>';
        }
    } else {
        // Chama o model somente se os campos obrigatórios estiverem preenchidos
        $msg = null;
        if (isset($this->carrinho) && method_exists($this->carrinho, 'salvar')) {
            $msg = $this->carrinho->salvar($_POST);
        } else {
            // Se o model não existir, tratamos como erro
            $msg = 0;
        }

        if ($msg === 1) {
            echo '<p class="alert alert-success text-center">Cadastro realizado com sucesso!<br>';
            echo '<a href="carrinho/finalizar"><i class="fa fa-sign-in"></i> Clique para fazer login</a></p>';
        } elseif ($msg === 2) {
            echo '<p class="alert alert-danger text-center">Email já cadastrado.<br><a href="javascript:history.back()">Voltar</a></p>';
        } else {
            echo '<p class="alert alert-danger text-center">Erro ao cadastrar. Tente novamente.<br><a href="javascript:history.back()">Voltar</a></p>';
        }
    }
} else {
    // Se a view for acessada sem POST, mostrar formulário básico ou instrução
    echo '<p class="alert alert-info text-center">Preencha o formulário de cadastro.</p>';
}

?>
