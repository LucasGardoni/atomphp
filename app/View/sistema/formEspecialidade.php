<?= formTitulo($aDados['titulo']) ?>

<div class="m-2">
    <form method="POST" action="<?= $this->request->formAction() ?>">
        <input type="hidden" name="id" value="<?= setValor('id', $aDados['especialidade']['id'] ?? '') ?>">

        <div class="mb-3">
            <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nome" name="nome" 
                   value="<?= setValor('nome', $aDados['especialidade']['nome'] ?? '') ?>" 
                   required>
            <?= setMsgFilderError("nome") ?>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= setValor('descricao', $aDados['especialidade']['descricao'] ?? '') ?></textarea>
        </div>

        <?= formButton() ?>
    </form>
</div>

<?php limpaDadosSessao(); ?>