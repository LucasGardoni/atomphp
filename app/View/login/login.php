<style>
    body {
        background-color: #f0f2f5;
    }
</style>

<div class="container-fluid  d-flex justify-content-center align-items-center p-3">

    <div class="card col-lg-4 shadow-lg border-0 rounded-4 p-2" style="max-width: 450px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">

                <h2 class="fw-bold">Bem-vindo(a)!</h2>
                <p class="text-muted">Faça login para continuar</p>
            </div>

            <form action="login/signIn" method="POST">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="email" name="email" placeholder="seu@email.com" value="<?= setValor("email") ?>" required autofocus>
                    <label for="email"><i class="fa-solid fa-envelope me-2"></i>Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Sua senha" required>
                    <label for="senha"><i class="fa-solid fa-lock me-2"></i>Senha</label>
                </div>

                <div class="text-end mb-3">
                    <a href="<?= baseUrl() ?>Login/esqueciASenha" class="text-decoration-none small">Esqueci minha senha</a>
                </div>

                <div class="col-12 mb-3">
                    <?= exibeAlerta() ?>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">Entrar</button>
                    <a href="<?= baseUrl() ?>" class="btn btn-outline-secondary">Voltar</a>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted mb-0">Não tem uma conta?</p>
                    <a href="/Login/cadastrarLogin" class="fw-bold text-decoration-none">Crie uma agora</a>
                </div>

            </form>
        </div>
    </div>

</div>