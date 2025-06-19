<?= formTitulo($aDados['titulo']) ?>
<div class="m-2">
    <form method="POST" action="<?= $this->request->formAction() ?>">
        <input type="hidden" name="id" value="<?= setValor('id', $aDados['horario']['id'] ?? '') ?>">
        <input type="hidden" name="fisioterapeuta_id" value="<?= $aDados['fisioterapeuta_id'] ?>">
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="dia_semana" class="form-label">Dia da Semana</label>
                <select name="dia_semana" id="dia_semana" class="form-select" required>
                    <option value="1">Segunda-feira</option>
                    <option value="2">Terça-feira</option>
                    <option value="3">Quarta-feira</option>
                    <option value="4">Quinta-feira</option>
                    <option value="5">Sexta-feira</option>
                    <option value="6">Sábado</option>
                    <option value="7">Domingo</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="hora_inicio" class="form-label">Hora de Início</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="hora_fim" class="form-label">Hora de Fim</label>
                <input type="time" name="hora_fim" id="hora_fim" class="form-control" required>
            </div>
        </div>
        <?= formButton() ?>
    </form>
</div>