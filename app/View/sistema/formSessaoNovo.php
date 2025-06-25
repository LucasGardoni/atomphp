<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/formSessao.css">
<?php
$action       = $aDados['action'] ?? 'insert';
$isViewMode   = ($action === 'view');
$disabledAttr = $isViewMode ? 'disabled' : '';
$formTitle    = $aDados['titulo']
  ?? ($action === 'insert' ? 'Agendar Nova Sessão'
    : ($action === 'update' ? 'Editar Sessão Agendada'
      : 'Visualizar Detalhes da Sessão'));
$sessao       = $aDados['sessao'] ?? [];
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
        <input type="hidden" name="sessao[id]" id="id" value="<?= $sessao['id'] ?? '' ?>">

        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <label for="fisioterapeuta_id" class="form-label">
              Fisioterapeuta <span class="text-danger">*</span>
            </label>
            <select id="fisioterapeuta_id" name="sessao[fisioterapeuta_id]"
              class="form-select" required <?= $disabledAttr ?>>
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
            <label for="paciente_id" class="form-label">
              Paciente <span class="text-danger">*</span>
            </label>
            <select id="paciente_id" name="sessao[paciente_id]"
              class="form-select" required <?= $disabledAttr ?>>
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
            <label for="data_selecionada" class="form-label">
              Data do Agendamento <span class="text-danger">*</span>
            </label>
            <input type="date" id="data_selecionada" name="sessao[data_selecionada]"
              class="form-control" required <?= $disabledAttr ?>
              value="<?= $sessao['data_selecionada'] ?? '' ?>">
          </div>
          <div class="col-md-8">
            <label class="form-label">
              Horários Disponíveis <span class="text-danger">*</span>
            </label>
            <div id="horarios-container"
              class="p-3 rounded bg-light-subtle d-flex flex-wrap gap-2"
              style="min-height:58px;">
              <small class="text-muted">Selecione um fisioterapeuta e data.</small>
            </div>
            <?= setMsgFilderError("data_hora_agendamento") ?>
          </div>
        </div>

        <input type="hidden" name="sessao[data_hora_agendamento]" id="data_hora_agendamento"
          value="<?= $sessao['data_hora_agendamento'] ?? '' ?>">

        <hr class="my-5">

        <div class="card bg-light border-light rounded-3 p-4 mb-4">
          <h5 class="fw-bold mb-3">Agendamento Recorrente</h5>
          <div class="row g-4">
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                  id="is_recorrente" name="sessao[is_recorrente]"
                  <?= !empty($sessao['is_recorrente']) ? 'checked' : '' ?>
                  <?= $disabledAttr ?>>
                <label class="form-check-label" for="is_recorrente">
                  Repetir sessão
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <label for="tipo_recorrencia" class="form-label">
                Repetir a cada:
              </label>
              <select id="tipo_recorrencia" name="sessao[tipo_recorrencia]"
                class="form-select" <?= $disabledAttr ?>>
                <?php foreach (['diariamente' => 'Dia', 'semanalmente' => 'Semana', 'quinzenalmente' => '15 dias', 'mensalmente' => 'Mês'] as $k => $v): ?>
                  <option value="<?= $k ?>"
                    <?= ($sessao['tipo_recorrencia'] ?? '') === $k ? 'selected' : '' ?>>
                    <?= $v ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="quantidade_repeticoes" class="form-label">
                Nº de repetições
              </label>
              <input type="number" id="quantidade_repeticoes" name="sessao[quantidade_repeticoes]"
                class="form-control" min="1" max="52"
                value="<?= $sessao['quantidade_repeticoes'] ?? 8 ?>"
                <?= $disabledAttr ?>>
            </div>
          </div>
        </div>

        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <label for="tipo_tratamento" class="form-label">
              Tipo de Tratamento <span class="text-danger">*</span>
            </label>
            <select id="tipo_tratamento" name="sessao[tipo_tratamento]"
              class="form-select" required <?= $disabledAttr ?>>

            </select>
            <?= setMsgFilderError("tipo_tratamento") ?>
          </div>
          <div class="col-md-6">
            <label for="status_sessao" class="form-label">
              Status <span class="text-danger">*</span>
            </label>
            <select id="status_sessao" name="sessao[status_sessao]"
              class="form-select" required <?= $disabledAttr ?>>
              <option value="Agendada"
                <?= ($sessao['status_sessao'] ?? '') === 'Agendada' ? 'selected' : '' ?>>
                Agendada
              </option>
            </select>
            <?= setMsgFilderError("status_sessao") ?>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-3 pt-4">
          <?php if (!$isViewMode): ?>
            <button type="submit" class="btn btn-custom-primary" id="btn-salvar-sessao">
              <i class="bi bi-check-lg me-2"></i>
              <?= $action === 'insert' ? 'Agendar' : 'Atualizar' ?> Sessão
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
    const horariosCt = document.getElementById('horarios-container');
    const dataHoraIn = document.getElementById('data_hora_agendamento');
    const btnSalvar = document.getElementById('btn-salvar-sessao');
    const tratSelect = document.getElementById('tipo_tratamento');
    const sessao = <?= json_encode($sessao) ?>;
    const initFisio = sessao.fisioterapeuta_id || '';
    const initTrat = sessao.tipo_tratamento || '';

    if (btnSalvar) btnSalvar.disabled = true;

    function buscarHorarios() {
      const fisio = fisioSelect.value,
        data = dataInput.value;
      dataHoraIn.value = '';
      if (btnSalvar) btnSalvar.disabled = true;
      if (!fisio || !data) {
        horariosCt.innerHTML = '<small class="text-muted">Selecione um fisioterapeuta e uma data.</small>';
        return;
      }
      horariosCt.innerHTML = 'Carregando horários...';
      fetch(`<?= baseUrl() ?>Sessao/getHorariosDisponiveis?fisioterapeuta_id=${fisio}&data=${data}`)
        .then(res => res.json())
        .then(list => {
          horariosCt.innerHTML = '';
          if (list.erro || list.length === 0) {
            horariosCt.innerHTML = `<span class="text-danger">${list.erro || 'Sem horários disponíveis.'}</span>`;
          } else {
            list.forEach(h => {
              const btn = document.createElement('button');
              btn.type = 'button';
              btn.className = 'btn btn-outline-success m-1';
              btn.textContent = h;
              btn.addEventListener('click', () => {
                horariosCt.querySelectorAll('button').forEach(x =>
                  x.classList.replace('btn-success', 'btn-outline-success')
                );
                btn.classList.replace('btn-outline-success', 'btn-success');
                dataHoraIn.value = `${data} ${h}:00`;
                btnSalvar.disabled = false;
              });
              horariosCt.appendChild(btn);
            });
          }
        })
        .catch(() => {
          horariosCt.innerHTML = '<span class="text-danger">Erro ao buscar horários.</span>';
        });
    }

    function carregarEspecialidades(fisioId, sel = '') {
      tratSelect.innerHTML = '';
      if (!fisioId) {
        tratSelect.innerHTML = '<option value="">Selecione o fisioterapeuta</option>';
        return;
      }
      const url = `<?= baseUrl() ?>Sessao/getEspecialidadesPorFisioterapeuta?fisioterapeuta_id=${fisioId}`;
      console.log('Fetch especialidades:', url);

      fetch(url)
        .then(res => {
          console.log('Status especialidades:', res.status, res.statusText);
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          return res.json();
        })
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
        .catch(err => {
          console.error('Erro ao carregar especialidades:', err);
          tratSelect.innerHTML = '<option value="">Erro ao carregar opções</option>';
        });
    }

    fisioSelect.addEventListener('change', () => {
      carregarEspecialidades(fisioSelect.value);
      buscarHorarios();
    });
    dataInput.addEventListener('change', buscarHorarios);

    if (initFisio) {
      carregarEspecialidades(initFisio, initTrat);
      buscarHorarios();
    }
  });
</script>