<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/form.css">
<?php
$aDados['usuario'] = $aDados['usuario'] ?? [];
$action = $this->request->getAction(); 
$isViewMode = ($action === 'view' || $action === 'delete'); 
$disabledAttribute = $isViewMode ? 'disabled' : '';

$aDados['usuario']['id'] = setValor('id');
$aDados['usuario']['nome'] = setValor('nome');
$aDados['usuario']['nivel'] = setValor('nivel');
$aDados['usuario']['email'] = setValor('email');
$aDados['usuario']['statusRegistro'] = setValor('statusRegistro');

$formTitle = 'Formulário do Usuário';
if ($action === 'insert') {
    $formTitle = 'Adicionar Novo Usuário';
} elseif ($action === 'update') {
    $formTitle = 'Editar Usuário';
} elseif ($action === 'view') {
    $formTitle = 'Visualizar Usuário';
} elseif ($action === 'delete') {
    $formTitle = 'Excluir Usuário';
}

?>

<div class="space-y-6 container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= baseUrl() ?>Usuario/index" class="btn btn-custom-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $formTitle ?></h1>
            <p class="text-muted">Preencha os detalhes do usuário.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Dados do Usuário</h5>
        </div>
        <div class="card-body py-4">
            <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>">
                <input type="hidden" name="id" id="id" value="<?= htmlspecialchars($aDados['usuario']['id'] ?? '') ?>">

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-8">
                        <label for="nome" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Nome Completo <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-custom" id="nome" name="nome"
                               value="<?= htmlspecialchars($aDados['usuario']['nome'] ?? '') ?>" required autofocus <?= $disabledAttribute ?>>
                        <?= setMsgFilderError('nome') ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="nivel" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Nível <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-custom" name="nivel" id="nivel" required <?= $disabledAttribute ?>>
                            <option value="" <?= ($aDados['usuario']['nivel'] == "" ? 'selected' : '') ?>>Selecione...</option>
                            <option value="1" <?= ($aDados['usuario']['nivel'] == "1" ? 'selected' : '') ?>>Super Administrador</option>
                            <option value="11" <?= ($aDados['usuario']['nivel'] == "11" ? 'selected' : '') ?>>Administrador</option>
                            <option value="21" <?= ($aDados['usuario']['nivel'] == "21" ? 'selected' : '') ?>>Usuário</option>
                        </select>
                        <?= setMsgFilderError('tipo') ?>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-8">
                        <label for="email" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            E-mail <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control form-control-custom" id="email" name="email"
                               value="<?= htmlspecialchars($aDados['usuario']['email'] ?? '') ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError('email') ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="statusRegistro" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-custom" name="statusRegistro" id="statusRegistro" required <?= $disabledAttribute ?>>
                            <option value="" <?= ($aDados['usuario']['statusRegistro'] == "" ? 'selected' : '') ?>>Selecione...</option>
                            <option value="1" <?= ($aDados['usuario']['statusRegistro'] == "1" ? 'selected' : '') ?>>Ativo</option>
                            <option value="2" <?= ($aDados['usuario']['statusRegistro'] == "2" ? 'selected' : '') ?>>Inativo</option>
                            <option value="3" <?= ($aDados['usuario']['statusRegistro'] == "3" ? 'selected' : '') ?>>Bloqueado</option>
                        </select>
                        <?= setMsgFilderError('statusRegistro') ?>
                    </div>
                </div>

                <?php if (in_array($action, ['insert', 'update'])): ?>
                <hr class="my-5">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="senha" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Senha <?= ($action == "insert" ? '<span class="text-danger">*</span>' : '') ?>
                        </label>
                        <input type="password" class="form-control form-control-custom" id="senha" name="senha"
                               placeholder="Informe uma senha" maxlength="60"
                               onkeyup="checa_segur_senha('senha', 'msgSenha', 'btEnviar');"
                               <?= ($action == "insert" ? 'required' : '') ?>>
                        <div id="msgSenha" class="mt-3 text-sm text-gray-600"></div>
                        <?= setMsgFilderError('senha') ?>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="confSenha" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Confirmar Senha <?= ($action == "insert" ? '<span class="text-danger">*</span>' : '') ?>
                        </label>
                        <input type="password" class="form-control form-control-custom" id="confSenha" name="confSenha"
                               placeholder="Digite a senha para conferência" maxlength="60"
                               onkeyup="checa_segur_senha('confSenha', 'msgConfSenha', 'btEnviar');"
                               <?= ($action == "insert" ? 'required' : '') ?>>
                        <div id="msgConfSenha" class="mt-3 text-sm text-gray-600"></div>
                        <?= setMsgFilderError('confSenha') ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="d-flex justify-content-end gap-3 pt-4">
                    <?php if (!$isViewMode): ?>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="bi bi-check-lg me-2"></i> Salvar Usuário
                        </button>
                    <?php endif; ?>
                    <a href="<?= baseUrl() ?>Usuario/index" class="btn btn-custom-secondary">
                        <i class="bi bi-x-lg me-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php limpaDadosSessao(); ?>
