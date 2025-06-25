<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/formSessao.css">
<?php
$action            = $aDados['action'] ?? 'update';
$isViewMode        = ($action === 'view');
$disabledAttr      = $isViewMode ? 'disabled' : '';
$sessao            = $aDados['sessao'] ?? [];
$formTitle         = $aDados['titulo']
  ?? ($action === 'update' ? 'Editar Sessão Agendada' : 'Visualizar Sessão');
?>
<div class="space-y-6 container py-4">
  <div class="d-flex align-items-center mb-4">
    <a href="<?= baseUrl() ?>Sessao/index" class="btn btn-custom-primary btn-sm me-3">
      <i class="bi bi-arrow-left me-2"></i> Voltar
    </a>
    <div>
      <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $formTitle ?></h1>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3">
      <h5 class="card-title fw-bold mb-0">Dados da Sessão</h5>
    </div>
    <div class="card-body py-4">
      <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>" id="form-sessao-editar">
        <input type="hidden" name="sessao[id]" value="<?= htmlspecialchars($sessao['id'] ?? '') ?>">

        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <label for="fisioterapeuta_id" class="form-label">Fisioterapeuta *</label>
            <select id="fisioterapeuta_id" name="sessao[fisioterapeuta_id]" class="form-select" required <?= $disabledAttr ?>>
              <option value="">Selecione...</option>
              <?php foreach ($aDados['lista_fisioterapeutas'] as $f): ?>
                <option value="<?= $f['id'] ?>"
                  <?= ($sessao['fisioterapeuta_id'] ?? '') == $f['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($f['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?= setMsgFilderError("fisioterapeuta_id") ?>
          </div>

          <div class="col-md-6">
            <label for="paciente_id" class="form-label">Paciente *</label>
            <select id="paciente_id" name="sessao[paciente_id]" class="form-select" required <?= $disabledAttr ?>>
              <option value="">Selecione...</option>
              <?php foreach ($aDados['lista_pacientes'] as $p): ?>
                <option value="<?= $p['id'] ?>"
                  <?= ($sessao['paciente_id'] ?? '') == $p['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($p['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?= setMsgFilderError("paciente_id") ?>
          </div>
        </div>

        <div class="row g-4 mb-4 align-items-end">
          <div class="col-md-4">
            <label for="data_selecionada" class="form-label">Data do Agendamento *</label>
            <input type="date" id="data_selecionada" name="sessao[data_selecionada]"
              class="form-control" required <?= $disabledAttr ?>
              value="<?= substr($sessao['data_hora_agendamento'] ?? '', 0, 10) ?>">
          </div>
          <div class="col-md-8">
            <label class="form-label">Horários Disponíveis *</label>
            <div id="horarios-container"
              class="p-3 rounded bg-light-subtle d-flex flex-wrap gap-2"
              style="min-height:58px;">
              <small class="text-muted">Selecione um fisioterapeuta e data.</small>
            </div>
            <?= setMsgFilderError("data_hora_agendamento") ?>
          </div>
        </div>

        <input type="hidden" name="sessao[data_hora_agendamento]" id="data_hora_agendamento"
          value="<?= htmlspecialchars($sessao['data_hora_agendamento'] ?? '') ?>">

        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <label for="tipo_tratamento" class="form-label">Tipo de Tratamento *</label>
            <select id="tipo_tratamento" name="sessao[tipo_tratamento]" class="form-select" required <?= $disabledAttr ?>>
              <option value="">Selecione o fisioterapeuta</option>
            </select>
            <?= setMsgFilderError("tipo_tratamento") ?>
          </div>
          <div class="col-md-6">
            <label for="status_sessao" class="form-label">Status *</label>
            <select id="status_sessao" name="sessao[status_sessao]" class="form-select" required <?= $disabledAttr ?>>
              <?php $st = $sessao['status_sessao'] ?? 'Agendada'; ?>
              <option value="Agendada" <?= $st === 'Agendada' ?      'selected' : '' ?>>Agendada</option>
              <option value="Realizada" <?= $st === 'Realizada' ?     'selected' : '' ?>>Realizada</option>
              <option value="Cancelada" <?= $st === 'Cancelada' ?     'selected' : '' ?>>Cancelada</option>
              <option value="Não Compareceu" <?= $st === 'Não Compareceu' ? 'selected' : '' ?>>Não Compareceu</option>
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fisioSelect = document.getElementById('fisioterapeuta_id');
    const dataInput = document.getElementById('data_selecionada');
    const horariosCt = document.getElementById('horarios-container');
    const dataHoraIn = document.getElementById('data_hora_agendamento');
    const btnSalvar = document.querySelector('#form-sessao-editar button[type=submit]');
    const tratSelect = document.getElementById('tipo_tratamento');

    const sessao = <?= json_encode($sessao) ?>;
    const initFisio = sessao.fisioterapeuta_id || '';
    const initDate = sessao.data_hora_agendamento ?
      sessao.data_hora_agendamento.slice(0, 10) :
      '';
    const initTime = sessao.data_hora_agendamento ?
      sessao.data_hora_agendamento.slice(11, 16) :
      '';

    if (btnSalvar) btnSalvar.disabled = true;

    function buscarHorarios() {
      const fisio = fisioSelect.value,
        data = dataInput.value;
      dataHoraIn.value = '';
      if (btnSalvar) btnSalvar.disabled = true;
      if (!fisio || !data) {
        horariosCt.innerHTML = '<small class="text-muted">Selecione fisioterapeuta e data.</small>';
        return;
      }
      horariosCt.innerHTML = 'Carregando horários…';
      fetch(`<?= baseUrl() ?>Sessao/getHorariosDisponiveis?fisioterapeuta_id=${fisio}&data=${data}`)
        .then(r => r.json())
        .then(list => {
          horariosCt.innerHTML = '';
          if (!list.length) {
            horariosCt.innerHTML = '<span class="text-danger">Sem horários disponíveis.</span>';
          } else list.forEach(h => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-outline-success m-1';
            btn.textContent = h;
            if (data === initDate && h === initTime) {
              btn.classList.replace('btn-outline-success', 'btn-success');
              dataHoraIn.value = sessao.data_hora_agendamento;
              if (btnSalvar) btnSalvar.disabled = false;
            }
            btn.addEventListener('click', () => {
              horariosCt.querySelectorAll('button').forEach(x =>
                x.classList.replace('btn-success', 'btn-outline-success')
              );
              btn.classList.replace('btn-outline-success', 'btn-success');
              dataHoraIn.value = data + ' ' + h + ':00';
              if (btnSalvar) btnSalvar.disabled = false;
            });
            horariosCt.appendChild(btn);
          });
        })
        .catch(() => horariosCt.innerHTML = '<span class="text-danger">Erro ao buscar horários.</span>');
    }

    function carregarEspecialidades(fisioId, sel = '') {
      tratSelect.innerHTML = '<option>Carregando…</option>';
      if (!fisioId) {
        tratSelect.innerHTML = '<option value="">Selecione o fisioterapeuta</option>';
        return;
      }
      fetch(`<?= baseUrl() ?>Sessao/getEspecialidadesPorFisioterapeuta?fisioterapeuta_id=${fisioId}`)
        .then(r => r.json())
        .then(list => {
          tratSelect.innerHTML = '';
          list.forEach(o => {
            const opt = document.createElement('option');
            opt.value = o.id;
            opt.textContent = o.nome;
            if (o.id == sel) opt.selected = true;
            tratSelect.appendChild(opt);
          });
        })
        .catch(() => tratSelect.innerHTML = '<option value="">Erro ao carregar opções</option>');
    }

    fisioSelect.addEventListener('change', () => {
      carregarEspecialidades(fisioSelect.value);
      buscarHorarios();
    });
    dataInput.addEventListener('change', buscarHorarios);

    if (initFisio) {
      dataInput.value = initDate;
      carregarEspecialidades(initFisio, sessao.tipo_tratamento);
      buscarHorarios();
    }
  });
</script>