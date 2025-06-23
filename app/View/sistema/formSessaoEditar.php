<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/formSessao.css">
<?php
$action = $aDados['action'] ?? 'update';
$isViewMode = ($action === 'view');
$disabledAttribute = $isViewMode ? 'disabled' : '';
$sessao = $aDados['sessao'] ?? null;

$formTitle = $aDados['titulo'] ?? 'Formulário da Sessão';
if ($action === 'insert') {
    $formTitle = 'Agendar Nova Sessão';
} elseif ($action === 'update') {
    $formTitle = 'Editar Sessão Agendada';
} elseif ($action === 'view') {
    $formTitle = 'Visualizar Detalhes da Sessão';
}
?>

<div class="space-y-6 container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= baseUrl() ?>Sessao/index" class="btn btn-custom-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $formTitle ?></h1>
            <p class="text-muted">Preencha os detalhes da sessão agendada.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Dados da Sessão</h5>
        </div>
        <div class="card-body py-4">
            <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>">
                <input type="hidden" name="id" id="id" value="<?= setValor("id", $sessao['id'] ?? '') ?>">

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="fisioterapeuta_id" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Fisioterapeuta <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-custom" id="fisioterapeuta_id" name="fisioterapeuta_id" required <?= $disabledAttribute ?>>
                            <option value="">Selecione...</option>
                            <?php foreach($aDados['lista_fisioterapeutas'] ?? [] as $fisio): ?>
                                <option value="<?= $fisio['id'] ?>" <?= (setValor("fisioterapeuta_id", $sessao['fisioterapeuta_id'] ?? '') == $fisio['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($fisio['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= setMsgFilderError("fisioterapeuta_id") ?>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="paciente_id" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Paciente <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-custom" id="paciente_id" name="paciente_id" required <?= $disabledAttribute ?>>
                            <option value="">Selecione...</option>
                            <?php foreach($aDados['lista_pacientes'] ?? [] as $paciente): ?>
                                <option value="<?= $paciente['id'] ?>" <?= (setValor("paciente_id", $sessao['paciente_id'] ?? '') == $paciente['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($paciente['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= setMsgFilderError("paciente_id") ?>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-4">
                        <label for="data_hora_agendamento" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Data e Hora <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control form-control-custom" id="data_hora_agendamento" name="data_hora_agendamento"
                               value="<?= setValor("data_hora_agendamento", !empty($sessao['data_hora_agendamento']) ? date('Y-m-d\TH:i', strtotime($sessao['data_hora_agendamento'])) : '') ?>"
                               required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("data_hora_agendamento") ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="tipo_tratamento" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Tipo de Tratamento
                        </label>
                        <input type="text" class="form-control form-control-custom" id="tipo_tratamento" name="tipo_tratamento" value="<?= setValor("tipo_tratamento", $sessao['tipo_tratamento'] ?? '') ?>" <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("tipo_tratamento") ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="status_sessao" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-custom" id="status_sessao" name="status_sessao" required <?= $disabledAttribute ?>>
                            <?php $statusAtual = setValor("status_sessao", $sessao['status_sessao'] ?? 'Agendada'); ?>
                            <option value="Agendada" <?= $statusAtual == 'Agendada' ? 'selected' : '' ?>>Agendada</option>
                            <option value="Realizada" <?= $statusAtual == 'Realizada' ? 'selected' : '' ?>>Realizada</option>
                            <option value="Cancelada" <?= $statusAtual == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                            <option value="Não Compareceu" <?= $statusAtual == 'Não Compareceu' ? 'selected' : '' ?>>Não Compareceu</option>
                        </select>
                        <?= setMsgFilderError("status_sessao") ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4">
                    <?php if (!$isViewMode): ?>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="bi bi-check-lg me-2"></i> Salvar
                        </button>
                    <?php endif; ?>
                    <a href="<?= baseUrl() ?>Sessao/index" class="btn btn-custom-secondary">
                        <i class="bi bi-x-lg me-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php limpaDadosSessao(); ?>

