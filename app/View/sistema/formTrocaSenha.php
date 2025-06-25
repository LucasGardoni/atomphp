<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/form.css">
<?php

use Core\Library\Session;
?>

<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/formPaciente.css">
<div class="space-y-6 container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= baseUrl() ?>" class="btn btn-custom-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Trocar a Senha</h1>
            <p class="text-muted">Atualize sua senha de acesso.</p>
        </div>
    </div>

    <?= exibeAlerta() ?>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Dados de Acesso</h5>
        </div>
        <div class="card-body py-4">
            <form method="POST" action="<?= baseUrl() ?>Usuario/updateNovaSenha">

                <input type="hidden" name="id" id="id" value="<?= Session::get("userId") ?>">

                <div class="mb-4">
                    <label class="form-label text-lg font-bold text-gray-900 mb-2">
                        Usuário: <span class="text-primary"><?= htmlspecialchars(Session::get('userNome')) ?></span>
                    </label>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="senhaAtual" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Senha Atual <span class="text-danger">*</span>
                        </label>
                        <input name="senhaAtual" id="senhaAtual" type="password" class="form-control form-control-custom" required="required">
                    </div>
                </div>

                <hr class="my-5">

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="novaSenha" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Nova Senha <span class="text-danger">*</span>
                        </label>
                        <input name="novaSenha" id="novaSenha" type="password" class="form-control form-control-custom" required="required"
                            onkeyup="checa_segur_senha( 'novaSenha', 'msgSenhaNova', 'btEnviar' );">
                        <div id="msgSenhaNova" class="mt-3 text-sm text-gray-600"></div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="novaSenha2" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Confirme a Nova Senha <span class="text-danger">*</span>
                        </label>
                        <input name="novaSenha2" id="novaSenha2" type="password" class="form-control form-control-custom" placeholder="Digite a nova senha novamente" required="required"
                            onkeyup="checa_segur_senha( 'novaSenha2', 'msgSenhaNova2', 'btEnviar' );">
                        <div id="msgSenhaNova2" class="mt-3 text-sm text-gray-600"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4">
                    <button type="submit" class="btn btn-custom-primary" id="btEnviar" disabled>
                        <i class="bi bi-check-lg me-2"></i> Atualizar Senha
                    </button>
                    <a href="<?= baseUrl() ?>" class="btn btn-custom-secondary">
                        <i class="bi bi-x-lg me-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/usuario.js"></script>