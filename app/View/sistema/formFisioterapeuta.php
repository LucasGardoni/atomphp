<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/formPaciente.css">
<?php
$action = $aDados['action'] ?? 'insert';
$isViewMode = ($action === 'view');
$disabledAttribute = $isViewMode ? 'disabled' : '';

// Ajustado para corresponder às variáveis do FisioterapeutaController
$fisioterapeuta = $aDados['fisioterapeuta'] ?? null;
$todasEspecialidades = $aDados['todas_especialidades'] ?? [];
$especialidadesSelecionadas = $aDados['especialidades_selecionadas'] ?? [];
?>

<div class="space-y-6 container py-4">
    <div class="d-flex align-items-center mb-4">
    <a href="<?= baseUrl() ?>Fisioterapeuta/index" class="btn btn-custom-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $aDados['titulo'] ?? 'Formulário do Fisioterapeuta' ?></h1>
            <p class="text-muted">Preencha os detalhes do fisioterapeuta.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Dados do Fisioterapeuta</h5>
        </div>
        <div class="card-body py-4">
            <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>">
                <input type="hidden" name="id" id="id" value="<?= setValor("id", $fisioterapeuta['id'] ?? '') ?>">

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-8">
                        <label for="nome" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Nome Completo <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-custom" id="nome" name="nome" value="<?= setValor("nome", $fisioterapeuta['nome'] ?? '') ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("nome") ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="crefito" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            CREFITO <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-custom" id="crefito" name="crefito" value="<?= setValor("crefito", $fisioterapeuta['crefito'] ?? '') ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("crefito") ?>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-4">
                        <label for="cpf" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            CPF <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-custom" id="cpf" name="cpf" value="<?= setValor("cpf", $fisioterapeuta['cpf'] ?? '') ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("cpf") ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="telefone" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Telefone
                        </label>
                        <input type="text" class="form-control form-control-custom" id="telefone" name="telefone" value="<?= setValor("telefone", $fisioterapeuta['telefone'] ?? '') ?>" <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("telefone") ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="email" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            E-mail
                        </label>
                        <input type="email" class="form-control form-control-custom" id="email" name="email" value="<?= setValor("email", $fisioterapeuta['email'] ?? '') ?>" <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("email") ?>
                    </div>
                </div>

                <hr class="my-5">
                <div class="mb-4">
                    <label class="form-label text-lg font-bold text-gray-900 mb-3">Especialidades</label>
                    <div class="border p-4 rounded-3 bg-light-subtle shadow-sm">
                        <div class="row g-3">
                            <?php if (empty($todasEspecialidades)): ?>
                                <div class="col-12">
                                    <div class="alert-custom-info">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle me-3 fs-4"></i>
                                            <div>
                                                <strong class="font-bold">Nenhuma especialidade cadastrada!</strong>
                                                <div class="mt-1">
                                                    Para selecionar, você precisa <a href="<?= baseUrl() ?>Especialidade/form/insert" class="text-decoration-none fw-bold">cadastrar uma primeiro</a>.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($todasEspecialidades as $especialidade): ?>
                                    <div class="col-12 col-md-4 col-sm-6">
                                        <div class="form-check form-check-custom-checkbox py-2 px-3">
                                            <input class="form-check-input" type="checkbox"
                                                   name="especialidades[]"
                                                   value="<?= $especialidade['id'] ?>"
                                                   id="especialidade_<?= $especialidade['id'] ?>"
                                                   <?= in_array($especialidade['id'], $especialidadesSelecionadas) ? 'checked' : '' ?>
                                                   <?= $disabledAttribute ?>>
                                            <label class="form-check-label text-gray-800" for="especialidade_<?= $especialidade['id'] ?>">
                                                <?= htmlspecialchars($especialidade['nome'])  ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-4">
                        <label for="status" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-custom" id="status" name="status" required <?= $disabledAttribute ?>>
                            <option value="1" <?= (setValor("status", $fisioterapeuta['status'] ?? '1') == "1" ? 'SELECTED' : '') ?>>Ativo</option>
                            <option value="0" <?= (setValor("status", $fisioterapeuta['status'] ?? '') == "0" ? 'SELECTED' : '') ?>>Inativo</option>
                        </select>
                        <?= setMsgFilderError("status") ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4">
                    <?php if (!$isViewMode): ?>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="bi bi-check-lg me-2"></i> Salvar
                        </button>
                    <?php endif; ?>
                    <a href="<?= baseUrl() ?>Fisioterapeuta/index" class="btn btn-custom-secondary">
                        <i class="bi bi-x-lg me-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php limpaDadosSessao(); ?>