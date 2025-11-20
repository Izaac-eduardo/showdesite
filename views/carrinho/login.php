<div class="card">
    
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <h2>Login</h2>
                <form action="carrinho/logar" name="formLogin" method="post" data-parsley-validate>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required data-parsley-required-message="Preencha o email"
                    data-parsley-type-message="Digite um email válido">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control" required data-parsley-required-message="Preencha a senha"
                    minlength="6" data-parsley-minlength-message="A senha deve ter no mínimo 6 caracteres"
                    > <br>
                    <button type="submit" class="btn btn-success">
                        Login
                    </button>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <h2>Cadastro</h2>
                <form action="carrinho/cadastrar" name="formCadastrar" method="post" data-parsley-validate>

                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="cli_nome" class="form-control" required data-parsley-required-message="Preencha o nome">

                        <label for="email">Email:</label>
                    <input type="email" name="email" id="cli_email" class="form-control" required data-parsley-required-message="Preencha o email"
                    data-parsley-type-message="Digite um email válido">

                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="cli_senha" class="form-control" required data-parsley-required-message="Preencha a senha"
                    minlength="6" data-parsley-minlength-message="A senha deve ter no mínimo 6 caracteres"
                    > 
                    <label for="confirmacao_senha">Confirme a senha:</label>
                    <input type="password" name="confirmacao_senha" id="confirmacao_senha" class="form-control" required data-parsley-required-message="Confirme a senha"
                    data-parsley-equalto="#cli_senha" data-parsley-equalto-message="As senhas não coincidem">
                    <br>
                    <button type="submit" class="btn btn-primary">
                        Cadastrar
                </form>
            </div>
        </div>
    </div>

</div>