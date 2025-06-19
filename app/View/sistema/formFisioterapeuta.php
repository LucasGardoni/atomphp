<?php
$action = $aDados['action'] ?? 'insert';
$isViewMode = ($action === 'view');
$disabledAttribute = $isViewMode ? 'disabled' : '';
?>

<?= formTitulo($aDados['titulo'] ?? 'Formulário do Fisioterapeuta') ?>

<div class="m-2">
    <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>">
        <input type="hidden" name="id" id="id" value="<?= setValor("id", $aDados['fisioterapeuta']['id'] ?? '') ?>">

        <div class="row">
            <div class="col-md-8 mb-3">
                <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="255" value="<?= setValor("nome", $aDados['fisioterapeuta']['nome'] ?? '') ?>" required <?= $disabledAttribute ?>>
                <?= setMsgFilderError("nome") ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="crefito" class="form-label">CREFITO <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="crefito" name="crefito" maxlength="20" value="<?= setValor("crefito", $aDados['fisioterapeuta']['crefito'] ?? '') ?>" required <?= $disabledAttribute ?>>
                <?= setMsgFilderError("crefito") ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" value="<?= setValor("cpf", $aDados['fisioterapeuta']['cpf'] ?? '') ?>" required <?= $disabledAttribute ?>>
                <?= setMsgFilderError("cpf") ?>
            </div>
            <div class="col-md-4 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" maxlength="20" value="<?= setValor("telefone", $aDados['fisioterapeuta']['telefone'] ?? '') ?>" <?= $disabledAttribute ?>>
                <?= setMsgFilderError("telefone") ?>
            </div>
             <div class="col-md-4 mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" maxlength="150" value="<?= setValor("email", $aDados['fisioterapeuta']['email'] ?? '') ?>" <?= $disabledAttribute ?>>
                <?= setMsgFilderError("email") ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-3">
                <label for="especialidade" class="form-label">Especialidade(s)</label>
                <input type="text" class="form-control" id="especialidade" name="especialidade" maxlength="100" value="<?= setValor("especialidade", $aDados['fisioterapeuta']['especialidade'] ?? '') ?>" <?= $disabledAttribute ?>>
                <?= setMsgFilderError("especialidade") ?>
            </div>
            <?php if ($action !== 'insert') : ?>
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-control" id="status" name="status" required <?= $disabledAttribute ?>>
                        <option value="1" <?= (setValor("status", $aDados['fisioterapeuta']['status'] ?? '1') == "1" ? 'SELECTED' : '') ?>>Ativo</option>
                        <option value="0" <?= (setValor("status", $aDados['fisioterapeuta']['status'] ?? '') == "0" ? 'SELECTED' : '') ?>>Inativo</option>
                    </select>
                    <?= setMsgFilderError("status") ?>
                </div>
            <?php else: ?>
                <input type="hidden" name="status" value="1">
            <?php endif; ?>
        </div>
        
        <?= formButton() ?>
    </form>
</div>