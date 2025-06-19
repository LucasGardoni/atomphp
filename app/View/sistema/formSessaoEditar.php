<?php
$action = $aDados['action'] ?? 'update';
$isViewMode = ($action === 'view');
$disabledAttribute = $isViewMode ? 'disabled' : '';
$sessao = $aDados['sessao'] ?? null;
?>

<?= formTitulo($aDados['titulo']) ?>

<div class="m-2">
    <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>">
        <input type="hidden" name="id" id="id" value="<?= setValor("id", $sessao['id'] ?? '') ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fisioterapeuta_id" class="form-label">Fisioterapeuta <span class="text-danger">*</span></label>
                <select class="form-select" id="fisioterapeuta_id" name="fisioterapeuta_id" required <?= $disabledAttribute ?>>
                    <option value="">Selecione...</option>
                    <?php foreach($aDados['lista_fisioterapeutas'] ?? [] as $fisio): ?>
                        <option value="<?= $fisio['id'] ?>" <?= (setValor("fisioterapeuta_id", $sessao['fisioterapeuta_id'] ?? '') == $fisio['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fisio['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="paciente_id" class="form-label">Paciente <span class="text-danger">*</span></label>
                <select class="form-select" id="paciente_id" name="paciente_id" required <?= $disabledAttribute ?>>
                    <option value="">Selecione...</option>
                    <?php foreach($aDados['lista_pacientes'] ?? [] as $paciente): ?>
                        <option value="<?= $paciente['id'] ?>" <?= (setValor("paciente_id", $sessao['paciente_id'] ?? '') == $paciente['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($paciente['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="data_hora_agendamento" class="form-label">Data e Hora <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control" id="data_hora_agendamento" name="data_hora_agendamento"
                       value="<?= setValor("data_hora_agendamento", !empty($sessao['data_hora_agendamento']) ? date('Y-m-d\TH:i', strtotime($sessao['data_hora_agendamento'])) : '') ?>" 
                       required <?= $disabledAttribute ?>>
            </div>
            <div class="col-md-4 mb-3">
                <label for="tipo_tratamento" class="form-label">Tipo de Tratamento</label>
                <input type="text" class="form-control" id="tipo_tratamento" name="tipo_tratamento" value="<?= setValor("tipo_tratamento", $sessao['tipo_tratamento'] ?? '') ?>" <?= $disabledAttribute ?>>
            </div>
            <div class="col-md-4 mb-3">
                <label for="status_sessao" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="status_sessao" name="status_sessao" required <?= $disabledAttribute ?>>
                    <?php $statusAtual = setValor("status_sessao", $sessao['status_sessao'] ?? 'Agendada'); ?>
                    <option value="Agendada" <?= $statusAtual == 'Agendada' ? 'selected' : '' ?>>Agendada</option>
                    <option value="Realizada" <?= $statusAtual == 'Realizada' ? 'selected' : '' ?>>Realizada</option>
                    <option value="Cancelada" <?= $statusAtual == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                    <option value="Não Compareceu" <?= $statusAtual == 'Não Compareceu' ? 'selected' : '' ?>>Não Compareceu</option>
                </select>
            </div>
        </div>

        <?= formButton() ?>
    </form>
</div>

<?php limpaDadosSessao(); ?>