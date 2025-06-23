<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/form.css">
<?php
$sessaoInfo = $aDados['sessao_info'] ?? null;
$titulo = "Ficha de Evolução";
$subtitulo = "Preencha a evolução clínica e recomendações da sessão.";
if ($sessaoInfo) {
    $titulo .= " - Paciente: " . htmlspecialchars($sessaoInfo['nome_paciente']);
    $subtitulo = "Sessão em: " . date('d/m/Y H:i', strtotime($sessaoInfo['data_hora_agendamento'])) . " | Paciente: " . htmlspecialchars($sessaoInfo['nome_paciente']);
}

$isViewMode = false;
if (!isset($this->request) || empty($this->request->formAction())) {
    if (isset($aDados['ficha_evolucao']['id']) && !empty($aDados['ficha_evolucao']['id'])) {
        $isViewMode = true;
    }
}
$disabledAttribute = $isViewMode ? 'disabled' : '';
?>

<div class="space-y-6 container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= baseUrl() ?>Sessao/index" class="btn btn-custom-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar para Agenda
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $titulo ?></h1>
            <p class="text-muted"><?= $subtitulo ?></p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Registro da Evolução</h5>
        </div>
        <div class="card-body py-4">
            <form method="POST" action="<?= $isViewMode ? '#' : baseUrl() . 'FichaEvolucao/save' ?>">
                <input type="hidden" name="id" value="<?= setValor("id", $aDados['ficha_evolucao']['id'] ?? '') ?>">
                <input type="hidden" name="sessao_id" value="<?= htmlspecialchars($sessaoInfo['id'] ?? '') ?>">

                <div class="mb-4">
                    <label for="descricao_evolucao" class="form-label text-sm font-semibold text-gray-800 mb-2">
                        Descrição da Evolução Clínica <span class="text-danger">*</span>
                        <small class="d-block text-muted mt-1">Descreva o que foi feito na sessão, a evolução do paciente, dificuldades encontradas, etc.</small>
                    </label>
                    <textarea class="form-control form-control-custom" id="descricao_evolucao" name="descricao_evolucao" rows="10" required <?= $disabledAttribute ?>><?= setValor("descricao_evolucao", $aDados['ficha_evolucao']['descricao_evolucao'] ?? '') ?></textarea>
                    <?= setMsgFilderError("descricao_evolucao") ?>
                </div>

                <div class="mb-4">
                    <label for="recomendacoes" class="form-label text-sm font-semibold text-gray-800 mb-2">
                        Recomendações
                        <small class="d-block text-muted mt-1">Instruções e recomendações para o paciente fazer em casa.</small>
                    </label>
                    <textarea class="form-control form-control-custom" id="recomendacoes" name="recomendacoes" rows="5" <?= $disabledAttribute ?>><?= setValor("recomendacoes", $aDados['ficha_evolucao']['recomendacoes'] ?? '') ?></textarea>
                    <?= setMsgFilderError("recomendacoes") ?>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4">
                    <?php if (!$isViewMode): ?>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="bi bi-check-lg me-2"></i> Salvar Ficha
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
