<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/form.css">
<?php
$action = $aDados['action'] ?? 'insert'; 
$isViewMode = ($action === 'view'); 
$disabledAttribute = $isViewMode ? 'disabled' : ''; 

// Definindo o título do formulário com base na ação
$formTitle = $aDados['titulo'] ?? 'Agendar Nova Sessão';
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
            <i class="bi bi-arrow-left me-2"></i> Voltar para Agenda
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $formTitle ?></h1>
            <p class="text-muted">Preencha os detalhes para agendar uma nova sessão.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Dados do Agendamento</h5>
        </div>
        <div class="card-body py-4">
            <form method="POST" action="<?= $this->request->formAction() ?>" id="form-sessao">
                <input type="hidden" name="id" id="id">

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="fisioterapeuta_id" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Fisioterapeuta <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-custom" id="fisioterapeuta_id" name="fisioterapeuta_id" required <?= $disabledAttribute ?>>
                            <option value="">Selecione...</option>
                            <?php foreach($aDados['lista_fisioterapeutas'] ?? [] as $fisio): ?>
                                <option value="<?= $fisio['id'] ?>"><?= htmlspecialchars($fisio['nome']) ?></option>
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
                                <option value="<?= $paciente['id'] ?>"><?= htmlspecialchars($paciente['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= setMsgFilderError("paciente_id") ?>
                    </div>
                </div>

                <div class="row g-4 mb-4 align-items-end">
                    <div class="col-12 col-md-4">
                        <label for="data_selecionada" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Data do Agendamento <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control form-control-custom" id="data_selecionada" required <?= $disabledAttribute ?>>
                    </div>
                    <div class="col-12 col-md-8">
                        <label class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Horários Disponíveis <span class="text-danger">*</span>
                        </label>
                        <div id="horarios-container" class="p-3 rounded bg-light-subtle d-flex flex-wrap gap-2 align-items-center" style="min-height: 58px;">
                            <small class="text-muted">Selecione um fisioterapeuta e uma data para ver os horários.</small>
                        </div>
                        <?= setMsgFilderError("data_hora_agendamento") ?>
                    </div>
                </div>

                <input type="hidden" name="data_hora_agendamento" id="data_hora_agendamento">

                <hr class="my-5">

                <div class="card bg-light border-light rounded-3 p-4 mb-4">
                    <h5 class="fw-bold mb-3 text-gray-900">Agendamento Recorrente</h5>
                    <div class="row g-4">
                        <div class="col-12 col-md-4">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_recorrente" name="is_recorrente" <?= $disabledAttribute ?>>
                                <label class="form-check-label text-sm font-semibold text-gray-800" for="is_recorrente">Repetir esta sessão</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="tipo_recorrencia" class="form-label text-sm font-semibold text-gray-800 mb-2">Repetir a cada:</label>
                            <select class="form-select form-select-custom" id="tipo_recorrencia" name="tipo_recorrencia" <?= $disabledAttribute ?>>
                                <option value="semanalmente" selected>Semana</option>
                                <option value="diariamente">Dia</option>
                                <option value="quinzenalmente">15 dias</option>
                                <option value="mensalmente">Mês</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="quantidade_repeticoes" class="form-label text-sm font-semibold text-gray-800 mb-2">Número de repetições:</label>
                            <input type="number" class="form-control form-control-custom" id="quantidade_repeticoes" name="quantidade_repeticoes" value="8" min="1" max="52" <?= $disabledAttribute ?>>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="tipo_tratamento" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Tipo de Tratamento
                        </label>
                        <input type="text" class="form-control form-control-custom" id="tipo_tratamento" name="tipo_tratamento" <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("tipo_tratamento") ?>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="status_sessao" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-custom" id="status_sessao" name="status_sessao" required <?= $disabledAttribute ?>>
                            <option value="Agendada" selected>Agendada</option>
                            </select>
                        <?= setMsgFilderError("status_sessao") ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4">
                    <?php if (!$isViewMode): ?>
                        <button type="submit" class="btn btn-custom-primary" id="btn-salvar-sessao">
                            <i class="bi bi-check-lg me-2"></i> Agendar Sessão
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fisioSelect = document.getElementById('fisioterapeuta_id');
    const dataInput = document.getElementById('data_selecionada');
    const horariosContainer = document.getElementById('horarios-container');
    const dataHoraCompletaInput = document.getElementById('data_hora_agendamento');

    const btnSalvar = document.getElementById('btn-salvar-sessao');

    
    if (btnSalvar) {
        btnSalvar.disabled = true;
    }

    function buscarHorarios() {
        const fisioId = fisioSelect.value;
        const data = dataInput.value;

        dataHoraCompletaInput.value = '';
        if (btnSalvar) btnSalvar.disabled = true;

        if (!fisioId || !data) {
            horariosContainer.innerHTML = '<small class="text-muted">Selecione um fisioterapeuta e uma data para ver os horários.</small>';
            return;
        }
        horariosContainer.innerHTML = 'Carregando...';

        const apiUrl = `<?= baseUrl() ?>Sessao/getHorariosDisponiveis?fisioterapeuta_id=${fisioId}&data=${data}`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(horarios => {
                horariosContainer.innerHTML = '';
                if (horarios.erro || horarios.length === 0) {
                    horariosContainer.innerHTML = `<span class="text-danger">${horarios.erro || 'Nenhum horário disponível para esta data.'}</span>`;
                } else {
                    horarios.forEach(horario => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn btn-outline-success custom-btn-horario m-1';
                        btn.textContent = horario;
                        btn.onclick = () => {
                            document.querySelectorAll('#horarios-container .btn-success.custom-btn-horario').forEach(b => {
                                b.classList.remove('btn-success');
                                b.classList.add('btn-outline-success');
                            });
                            btn.classList.remove('btn-outline-success');
                            btn.classList.add('btn-success');
                            dataHoraCompletaInput.value = `${data} ${horario}:00`;
                            if (btnSalvar) btnSalvar.disabled = false;
                        };
                        horariosContainer.appendChild(btn);
                    });
                }
            })
            .catch(error => {
                horariosContainer.innerHTML = '<span class="text-danger">Erro ao buscar horários. Tente novamente.</span>';
                console.error('Error:', error);
            });
    }

    fisioSelect.addEventListener('change', buscarHorarios);
    dataInput.addEventListener('change', buscarHorarios);
});
</script>

<?php limpaDadosSessao(); ?>
