<?= formTitulo($aDados['titulo']) ?>

<div class="m-2">
    <form method="POST" action="<?= $this->request->formAction() ?>">
        <input type="hidden" name="id" value="<?= setValor('id', $aDados['plano_saude']['id'] ?? '') ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nome_plano" class="form-label">Nome do Plano <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nome_plano" name="nome_plano"
                    value="<?= setValor('nome_plano', $aDados['plano_saude']['nome_plano'] ?? '') ?>"
                    required>
                <?= setMsgFilderError("nome_plano") ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="contato_responsavel" class="form-label">Contato Responsável</label>
                <input type="text" class="form-control" id="contato_responsavel" name="contato_responsavel"
                    value="<?= setValor('contato_responsavel', $aDados['plano_saude']['contato_responsavel'] ?? '') ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone"
                    value="<?= setValor('telefone', $aDados['plano_saude']['telefone'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="1" <?= (setValor('status', $aDados['plano_saude']['status'] ?? '1') == '1') ? 'selected' : '' ?>>Ativo</option>
                    <option value="0" <?= (setValor('status', $aDados['plano_saude']['status'] ?? '') == '0') ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        </div>

        <?= formButton() ?>
    </form>
</div>

<?php limpaDadosSessao(); ?>