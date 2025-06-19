<?= formTitulo($aDados['titulo']) ?>

<div class="m-2">
    <form method="POST" action="<?= $this->request->formAction() ?>" id="form-sessao">
        <input type="hidden" name="id" id="id">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fisioterapeuta_id" class="form-label">Fisioterapeuta <span class="text-danger">*</span></label>
                <select class="form-select" id="fisioterapeuta_id" name="fisioterapeuta_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach($aDados['lista_fisioterapeutas'] ?? [] as $fisio): ?>
                        <option value="<?= $fisio['id'] ?>"><?= htmlspecialchars($fisio['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="paciente_id" class="form-label">Paciente <span class="text-danger">*</span></label>
                <select class="form-select" id="paciente_id" name="paciente_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach($aDados['lista_pacientes'] ?? [] as $paciente): ?>
                        <option value="<?= $paciente['id'] ?>"><?= htmlspecialchars($paciente['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-4 mb-3">
                <label for="data_selecionada" class="form-label">Data do Agendamento <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="data_selecionada" required>
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label">Horários Disponíveis <span class="text-danger">*</span></label>
                <div id="horarios-container" class="border p-2 rounded" style="min-height: 58px;">
                    <small class="text-muted">Selecione um fisioterapeuta e uma data.</small>
                </div>
                <?= setMsgFilderError("data_hora_agendamento") ?>
            </div>
        </div>
        
        <input type="hidden" name="data_hora_agendamento" id="data_hora_agendamento">

        <hr>
        <div class="row p-3 mb-3 border rounded bg-light">
            <h5 class="mb-3">Agendamento Recorrente</h5>
            <div class="col-md-4"><div class="form-check form-switch mt-2"><input class="form-check-input" type="checkbox" role="switch" id="is_recorrente" name="is_recorrente"><label class="form-check-label" for="is_recorrente">Repetir esta sessão</label></div></div>
            <div class="col-md-4"><label for="tipo_recorrencia" class="form-label">Repetir a cada:</label><select class="form-select" id="tipo_recorrencia" name="tipo_recorrencia"><option value="semanalmente" selected>Semana</option><option value="diariamente">Dia</option><option value="quinzenalmente">15 dias</option><option value="mensalmente">Mês</option></select></div>
            <div class="col-md-4"><label for="quantidade_repeticoes" class="form-label">Número de repetições:</label><input type="number" class="form-control" id="quantidade_repeticoes" name="quantidade_repeticoes" value="8" min="1" max="52"></div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tipo_tratamento" class="form-label">Tipo de Tratamento</label>
                <input type="text" class="form-control" id="tipo_tratamento" name="tipo_tratamento">
            </div>
            <div class="col-md-6 mb-3">
                <label for="status_sessao" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="status_sessao" name="status_sessao" required>
                    <option value="Agendada" selected>Agendada</option>
                </select>
            </div>
        </div>

        <?= formButton() ?>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fisioSelect = document.getElementById('fisioterapeuta_id');
    const dataInput = document.getElementById('data_selecionada');
    const horariosContainer = document.getElementById('horarios-container');
    const dataHoraCompletaInput = document.getElementById('data_hora_agendamento');
    
    // Encontra o botão de salvar/enviar dentro do formulário
    const btnSalvar = document.querySelector('#form-sessao button[type="submit"]');

    // Desabilita o botão de salvar inicialmente
    if (btnSalvar) {
        btnSalvar.disabled = true;
    }

    function buscarHorarios() {
        const fisioId = fisioSelect.value;
        const data = dataInput.value;
        
        // Sempre que buscar novos horários, limpa a seleção e desabilita o botão
        dataHoraCompletaInput.value = '';
        if (btnSalvar) btnSalvar.disabled = true;

        if (!fisioId || !data) {
            horariosContainer.innerHTML = '<small class="text-muted">Selecione um fisioterapeuta e uma data.</small>';
            return;
        }
        horariosContainer.innerHTML = 'Carregando...';
        
        const apiUrl = `<?= baseUrl() ?>Sessao/getHorariosDisponiveis?fisioterapeuta_id=${fisioId}&data=${data}`;
        
        fetch(apiUrl)
            .then(response => response.json())
            .then(horarios => {
                horariosContainer.innerHTML = '';
                if (horarios.erro || horarios.length === 0) {
                    horariosContainer.innerHTML = `<span class="text-danger">${horarios.erro || 'Nenhum horário disponível.'}</span>`;
                } else {
                    horarios.forEach(horario => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn btn-outline-success m-1';
                        btn.textContent = horario;
                        btn.onclick = () => {
                            document.querySelectorAll('#horarios-container .btn-success').forEach(b => b.className = 'btn btn-outline-success m-1');
                            btn.className = 'btn btn-success m-1';
                            dataHoraCompletaInput.value = `${data} ${horario}:00`;
                            // Habilita o botão de salvar APENAS quando um horário é selecionado
                            if (btnSalvar) btnSalvar.disabled = false;
                        };
                        horariosContainer.appendChild(btn);
                    });
                }
            })
            .catch(error => {
                horariosContainer.innerHTML = '<span class="text-danger">Erro ao buscar horários.</span>';
                console.error('Error:', error);
            });
    }

    fisioSelect.addEventListener('change', buscarHorarios);
    dataInput.addEventListener('change', buscarHorarios);
});
</script>

<?php limpaDadosSessao(); ?>