<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/form.css">
<div class="space-y-6 container py-4 max-w-lg mx-auto">
  <h1 class="text-2xl font-bold mb-4">Cadastro de Usuário</h1>

  <?php if (!empty($msgError)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($msgError) ?></div>
  <?php endif; ?>

  <form method="POST" action="<?= baseUrl() ?>Login/cadastrarLogin" class="space-y-4">
    <div>
      <label class="form-label">Nome Completo <span class="text-danger">*</span></label>
      <input type="text" name="nome" class="form-control" required value="<?= setValor('nome') ?>">
      <?= setMsgFilderError('nome') ?>
    </div>

    <div>
      <label class="form-label">E-mail <span class="text-danger">*</span></label>
      <input type="email" name="email" class="form-control" required value="<?= setValor('email') ?>">
      <?= setMsgFilderError('email') ?>
    </div>

    <div>
      <label class="form-label">Senha <span class="text-danger">*</span></label>
      <input type="password" name="senha" class="form-control" required>
      <?= setMsgFilderError('senha') ?>
    </div>

    <div>
      <label class="form-label">Confirme a Senha <span class="text-danger">*</span></label>
      <input type="password" name="senha_confirma" class="form-control" required>
    </div>

    <div class="flex justify-end gap-2">
      <a href="<?= baseUrl() ?>Login" class="btn btn-secondary">Cancelar</a>
      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </div>
  </form>
</div>