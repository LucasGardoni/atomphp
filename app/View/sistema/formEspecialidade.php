<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/form.css">

<?php
$action = $aDados['action'] ?? 'insert';
$isViewMode = ($action === 'view');
$disabledAttribute = $isViewMode ? 'disabled' : '';

$errors = $aDados['erros'] ?? [];
$especialidadeData = $aDados['especialidade'] ?? [];
?>

<div class="space-y-6 container py-4">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>Por favor, corrija os seguintes erros:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="d-flex align-items-center mb-4">
        <a href="<?= baseUrl() ?>Especialidade" class="btn btn-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-0"><?= $aDados['titulo'] ?? 'Formulário de Especialidade' ?></h1>
            <p class="text-muted mb-0">Gerencie os detalhes da especialidade.</p>
        </div>
    </div>

    <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>" class="space-y-6">
        <input type="hidden" name="id" value="<?= setValor('id', $especialidadeData['id'] ?? '') ?>">

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3">
                <h5 class="card-title fw-bold mb-0">Dados da Especialidade</h5>
            </div>
            <div class="card-body py-4">
                <div class="row g-4">
                    <div class="col-12">
                        <label for="nome" class="form-label font-semibold">Nome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom" id="nome" name="nome"
                            value="<?= setValor('nome', $especialidadeData['nome'] ?? '') ?>"
                            required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("nome") ?>
                    </div>

                    <div class="col-12">
                        <label for="descricao" class="form-label font-semibold">Descrição</label>
                        <textarea class="form-control form-control-custom" id="descricao" name="descricao" rows="5" <?= $disabledAttribute ?>><?= setValor('descricao', $especialidadeData['descricao'] ?? '') ?></textarea>
                        <?= setMsgFilderError("descricao") ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <?php if (!$isViewMode) : ?>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i> Salvar Especialidade
                </button>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php limpaDadosSessao(); ?>

<script src="<?= baseUrl() ?>assets/ckeditor5/ckeditor5-build-classic/ckeditor.js"></script>
<script>
    const isViewMode = <?= json_encode($isViewMode) ?>;
    const descricaoElement = document.querySelector('#descricao');

    if (!isViewMode) {
        ClassicEditor
            .create(descricaoElement)
            .catch(error => {
                console.error(error);
            });
    } else {}
</script>
