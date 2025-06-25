<?= formTitulo("Contato") ?>


<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/formPaciente.css">
<?php
$isViewMode = false;
$disabledAttribute = $isViewMode ? 'disabled' : '';
?>

<div class="space-y-6 container py-4">
    <div class="d-flex align-items-center mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Entre em Contato</h1>
            <p class="text-muted">
                Envie-nos uma mensagem e retornaremos em breve.
            </p>
        </div>
    </div>

    <form method="POST" action="<?= $this->request->formAction() ?>" class="space-y-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3">
                <h5 class="card-title fw-bold mb-0">Seus Dados</h5>
            </div>
            <div class="card-body py-4">
                <div class="row g-4">
                    <div class="col-12 col-md-6 space-y-2">
                        <label for="nome" class="form-label font-semibold text-gray-800">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom" id="nome" name="nome" placeholder="Seu nome completo" maxlength="255"
                            value="<?= setValor("nome", '') ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("nome") ?>
                    </div>
                    <div class="col-12 col-md-6 space-y-2">
                        <label for="email" class="form-label font-semibold text-gray-800">E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-custom" id="email" name="email" placeholder="seu.email@exemplo.com" maxlength="255"
                            value="<?= setValor("email", '') ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("email") ?>
                    </div>
                    <div class="col-12 col-md-6 space-y-2">
                        <label for="celular" class="form-label font-semibold text-gray-800">Celular</label>
                        <input type="text" class="form-control form-control-custom phone" id="celular" name="celular" placeholder="(00) 00000-0000" maxlength="20"
                            value="<?= setValor("celular", '') ?>" <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("celular") ?>
                    </div>
                    <div class="col-12 col-md-6 space-y-2">
                        <label for="assunto" class="form-label font-semibold text-gray-800">Assunto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom" id="assunto" name="assunto" placeholder="Assunto da sua mensagem" maxlength="100"
                            value="<?= setValor("assunto", '') ?>" required <?= $disabledAttribute ?>>
                        <?= setMsgFilderError("assunto") ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3">
                <h5 class="card-title fw-bold mb-0">Sua Mensagem</h5>
            </div>
            <div class="card-body py-4">
                <div class="row g-4">
                    <div class="col-12 space-y-2">
                        <label for="mensagem" class="form-label font-semibold text-gray-800">Mensagem <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-custom" id="mensagem" name="mensagem" rows="6" placeholder="Digite sua mensagem aqui..." required <?= $disabledAttribute ?>><?= setValor("mensagem", '') ?></textarea>
                        <?= setMsgFilderError("mensagem") ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end space-x-4 mt-4">
            <button type="submit" class="btn btn-custom-primary">
                <i class="bi bi-send me-2"></i> Enviar Mensagem
            </button>
        </div>

        <?= exibeAlerta() ?>
    </form>
</div>

<?= $this->section('js') ?>

<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>



<script>
    $(document).ready(function() {
        $('.phone').mask('(00) 00000-0000');
    });
</script>

<?= $this->endSection() ?>