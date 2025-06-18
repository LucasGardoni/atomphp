<?php
// A ação é usada apenas para o atributo 'disabled' e para o título
$action = $aDados['action'] ?? 'insert';
$isViewMode = ($action === 'view');
$disabledAttribute = $isViewMode ? 'disabled' : '';
?>

<?= formTitulo($aDados['titulo'] ?? 'Formulário do Paciente') ?>

<div class="m-2">
    <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>">
        <input type="hidden" name="id" id="id" value="<?= setValor("id", $aDados['paciente']['id'] ?? '') ?>">

        <div class="row">
            <div class="col-md-8 mb-3">
                <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo do paciente" maxlength="255"
                       value="<?= setValor("nome", $aDados['paciente']['nome'] ?? '') ?>" required <?= $disabledAttribute ?>>
                <?= setMsgFilderError("nome") ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14"
                       value="<?= setValor("cpf", $aDados['paciente']['cpf'] ?? '') ?>" <?= $disabledAttribute ?>>
                <?= setMsgFilderError("cpf") ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                       value="<?= setValor("data_nascimento", $aDados['paciente']['data_nascimento'] ?? '') ?>" <?= $disabledAttribute ?>>
                <?= setMsgFilderError("data_nascimento") ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000" maxlength="20"
                       value="<?= setValor("telefone", $aDados['paciente']['telefone'] ?? '') ?>" <?= $disabledAttribute ?>>
                <?= setMsgFilderError("telefone") ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="plano_saude" class="form-label">Plano de Saúde</label>
                <input type="text" class="form-control" id="plano_saude" name="plano_saude" placeholder="Nome do plano de saúde" maxlength="100"
                       value="<?= setValor("plano_saude", $aDados['paciente']['plano_saude'] ?? '') ?>" <?= $disabledAttribute ?>>
                <?= setMsgFilderError("plano_saude") ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="endereco" class="form-label">Endereço Completo</label>
                <textarea class="form-control" id="endereco" name="endereco" rows="3" placeholder="Rua, Número, Bairro, Cidade - UF, CEP" <?= $disabledAttribute ?>><?= setValor("endereco", $aDados['paciente']['endereco'] ?? '') ?></textarea>
                <?= setMsgFilderError("endereco") ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="historico_clinico" class="form-label">Histórico Clínico Relevante</label>
                <textarea class="form-control" id="historico_clinico" name="historico_clinico" rows="5" placeholder="Descreva o histórico clínico relevante do paciente" <?= $disabledAttribute ?>><?= setValor("historico_clinico", $aDados['paciente']['historico_clinico'] ?? '') ?></textarea>
                <?= setMsgFilderError("historico_clinico") ?>
            </div>
        </div>
        <?php if ($action !== 'insert') : ?>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-control" id="status" name="status" required <?= $disabledAttribute ?>>
                        <option value="1" <?= (setValor("status", $aDados['paciente']['status'] ?? '1') == "1" ? 'SELECTED' : '') ?>>Ativo</option>
                        <option value="0" <?= (setValor("status", $aDados['paciente']['status'] ?? '') == "0" ? 'SELECTED' : '') ?>>Inativo</option>
                    </select>
                    <?= setMsgFilderError("status") ?>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="status" value="1">
        <?php endif; ?>

        <?= formButton() ?>

    </form>
</div>