<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/form.css">
<?php
$action = $aDados['action'] ?? 'insert';
$isViewMode = ($action === 'view');
$disabledAttribute = $isViewMode ? 'disabled' : '';

$fisioterapeutaNome = $aDados['fisioterapeuta_nome'] ?? 'Fisioterapeuta Desconhecido';


$formTitle = $aDados['titulo'] ?? 'Cadastrar Horário';
$subTitle = "Adicione um novo horário de atendimento para " . htmlspecialchars($fisioterapeutaNome) . ".";

if ($action === 'insert') {
    $formTitle = 'Cadastrar Novo Horário';
} elseif ($action === 'update') {
    $formTitle = 'Editar Horário de Atendimento';
    $subTitle = "Edite o horário de atendimento para " . htmlspecialchars($fisioterapeutaNome) . ".";
} elseif ($action === 'view') {
    $formTitle = 'Visualizar Horário de Atendimento';
    $subTitle = "Detalhes do horário de atendimento de " . htmlspecialchars($fisioterapeutaNome) . ".";
}

$selectedDiaSemana = setValor('dia_semana', $aDados['horario']['dia_semana'] ?? '');
$horaInicio = setValor('hora_inicio', $aDados['horario']['hora_inicio'] ?? '');
$horaFim = setValor('hora_fim', $aDados['horario']['hora_fim'] ?? '');
?>

<div class="space-y-6 container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= baseUrl() ?>Fisioterapeuta/horarios/<?= $aDados['fisioterapeuta_id'] ?>" class="btn btn-custom-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar para Horários
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $formTitle ?></h1>
            <p class="text-muted"><?= $subTitle ?></p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Informações do Horário</h5>
        </div>
        <div class="card-body py-4">
            <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>">
                <input type="hidden" name="id" value="<?= setValor('id', $aDados['horario']['id'] ?? '') ?>">
                <input type="hidden" name="fisioterapeuta_id" value="<?= $aDados['fisioterapeuta_id'] ?>">

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-4">
                        <label for="dia_semana" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Dia da Semana <span class="text-danger">*</span>
                        </label>
                        <select name="dia_semana" id="dia_semana" class="form-select form-select-custom" required <?= $disabledAttribute ?>>
                            <option value="1" <?= ($selectedDiaSemana == '1') ? 'selected' : '' ?>>Segunda-feira</option>
                            <option value="2" <?= ($selectedDiaSemana == '2') ? 'selected' : '' ?>>Terça-feira</option>
                            <option value="3" <?= ($selectedDiaSemana == '3') ? 'selected' : '' ?>>Quarta-feira</option>
                            <option value="4" <?= ($selectedDiaSemana == '4') ? 'selected' : '' ?>>Quinta-feira</option>
                            <option value="5" <?= ($selectedDiaSemana == '5') ? 'selected' : '' ?>>Sexta-feira</option>
                            <option value="6" <?= ($selectedDiaSemana == '6') ? 'selected' : '' ?>>Sábado</option>
                            <option value="7" <?= ($selectedDiaSemana == '7') ? 'selected' : '' ?>>Domingo</option>
                        </select>
                        <?= setMsgFilderError("dia_semana") ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="hora_inicio" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Hora de Início <span class="text-danger">*</span>
                        </label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control form-control-custom" value="<?= $horaInicio ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("hora_inicio") ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="hora_fim" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Hora de Fim <span class="text-danger">*</span>
                        </label>
                        <input type="time" name="hora_fim" id="hora_fim" class="form-control form-control-custom" value="<?= $horaFim ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("hora_fim") ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4">
                    <?php if (!$isViewMode): ?>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="bi bi-check-lg me-2"></i> Salvar Horário
                        </button>
                    <?php endif; ?>
                    <a href="<?= baseUrl() ?>Fisioterapeuta/horarios/<?= $aDados['fisioterapeuta_id'] ?>" class="btn btn-custom-secondary">
                        <i class="bi bi-x-lg me-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php limpaDadosSessao(); ?>