<?php 
$email = $_POST["email"] ?? null;
$senha = $_POST["senha"] ?? null;
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Email inválido');history.back();</script>";
    
}
$dados = $this->carrinho->logar($email);
if(empty($dados->id)){
    echo "<script>alert('Usuário não encontrado');history.back();</script>";
    
} else if(!password_verify($senha, $dados->senha)) {
    echo "<script>alert('Usuário não encontrado');history.back();</script>";
}
$_SESSION["cliente"] = array("id" => $dados->id,
"nome" => $dados->nome,
"email" => $dados->email);
echo "<script>location.href='carrinho/index';</script>";