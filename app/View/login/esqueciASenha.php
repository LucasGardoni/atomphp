<style>
  body {
    background-color: #f0f2f5; /* Maintain the same light gray background */
  }
</style>

<div class="container-fluid d-flex justify-content-center align-items-center  p-3">
    <div class="card col-12 col-md-8 col-lg-4 shadow-lg border-0 rounded-4 p-2" style="max-width: 450px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Recuperar Senha</h2> <p class="text-muted">Informe seu e-mail para redefinir sua senha</p> </div>

            <form action="<?= baseUrl() ?>login/esqueciASenhaEnvio" method="POST">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" value="<?= setValor("email") ?>" required autofocus>
                    <label for="email"><i class="fa-solid fa-envelope me-2"></i>Email</label>
                </div>

                <div class="col-12 mb-3">
                    <?= exibeAlerta() ?>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">Enviar Link</button> <a href="<?= baseUrl() ?>login" class="btn btn-outline-secondary">Voltar ao Login</a> </div>

                <div class="text-center mt-4">
                    <p class="text-muted mb-0">Lembrou da senha?</p>
                    <a href="<?= baseUrl() ?>Login" class="fw-bold text-decoration-none">Faça Login aqui</a> </div>
            </form>
        </div>
    </div>
</div>