<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/formPaciente.css">
<?php
$action = $aDados['action'] ?? 'insert';
$isViewMode = ($action === 'view');
$disabledAttribute = $isViewMode ? 'disabled' : '';


$errors = $aDados['erros'] ?? [];

?>

<div class="space-y-6 container py-4">


<?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>Por favor, corrija os seguintes erros:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
<?php endif; ?>


    <div class="d-flex align-items-center mb-4">
        <a href="<?= baseUrl() ?>Paciente" class="btn btn-custom-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $aDados['titulo'] ?? 'Formulário do Paciente' ?></h1>
        </div>
    </div>

    <form method="POST" action="<?= $isViewMode ? '#' : $this->request->formAction() ?>" class="space-y-6">
        <input type="hidden" name="paciente[id]" value="<?= setValor("id", $aDados['paciente']['id'] ?? '') ?>">
        <input type="hidden" name="endereco[id]" value="<?= setValor('id', $aDados['endereco']['id'] ?? '') ?>">

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3"><h5 class="card-title fw-bold mb-0">Dados Pessoais</h5></div>
            <div class="card-body py-4">
                <div class="row g-4">
                    <div class="col-12 col-md-6"><label class="form-label font-semibold">Nome Completo <span class="text-danger">*</span></label><input type="text" class="form-control form-control-custom" name="paciente[nome]" value="<?= setValor("nome", $aDados['paciente']['nome'] ?? '') ?>" required <?= $disabledAttribute ?>></div>
                    <div class="col-12 col-md-6"><label class="form-label font-semibold">CPF</label><input type="text" class="form-control form-control-custom" name="paciente[cpf]" value="<?= setValor("cpf", $aDados['paciente']['cpf'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                    <div class="col-12 col-md-6"><label class="form-label font-semibold">Data de Nascimento</label><input type="date" class="form-control form-control-custom" name="paciente[data_nascimento]" value="<?= setValor("data_nascimento", $aDados['paciente']['data_nascimento'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                    <div class="col-12 col-md-6"><label class="form-label font-semibold">Telefone</label><input type="text" class="form-control form-control-custom" name="paciente[telefone]" value="<?= setValor("telefone", $aDados['paciente']['telefone'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3"><h5 class="card-title fw-bold mb-0">Endereço</h5></div>
            <div class="card-body py-4">
                <div class="row g-4">
                    <div class="col-md-3"><label for="cep" class="form-label font-semibold">CEP</label><input type="text" class="form-control form-control-custom" id="cep" name="endereco[cep]" value="<?= setValor('cep', $aDados['endereco']['cep'] ?? '') ?>" <?= $disabledAttribute ?>><div id="cep-feedback"></div></div>
                    <div class="col-md-7"><label for="logradouro" class="form-label font-semibold">Logradouro</label><input type="text" class="form-control form-control-custom" id="logradouro" name="endereco[logradouro]" value="<?= setValor('logradouro', $aDados['endereco']['logradouro'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                    <div class="col-md-2"><label for="numero" class="form-label font-semibold">Número</label><input type="text" class="form-control form-control-custom" id="numero" name="endereco[numero]" value="<?= setValor('numero', $aDados['endereco']['numero'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                    <div class="col-md-3"><label for="complemento" class="form-label font-semibold">Complemento</label><input type="text" class="form-control form-control-custom" id="complemento" name="endereco[complemento]" value="<?= setValor('complemento', $aDados['endereco']['complemento'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                    <div class="col-md-3"><label for="bairro" class="form-label font-semibold">Bairro</label><input type="text" class="form-control form-control-custom" id="bairro" name="endereco[bairro]" value="<?= setValor('bairro', $aDados['endereco']['bairro'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                    <div class="col-md-4"><label for="cidade" class="form-label font-semibold">Cidade</label><input type="text" class="form-control form-control-custom" id="cidade" name="endereco[cidade]" value="<?= setValor('cidade', $aDados['endereco']['cidade'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                    <div class="col-md-2"><label for="uf" class="form-label font-semibold">UF</label><input type="text" class="form-control form-control-custom" id="uf" name="endereco[uf]" value="<?= setValor('uf', $aDados['endereco']['uf'] ?? '') ?>" <?= $disabledAttribute ?>></div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3"><h5 class="card-title fw-bold mb-0">Outras Informações</h5></div>
    <div class="card-body py-4">
        <div class="row g-4">
            <div class="col-12 col-md-6">
                <label for="plano_saude_id" class="form-label font-semibold">Plano de Saúde</label>
                
                <!-- CAMPO DE TEXTO TROCADO POR UMA COMBOBOX (SELECT) -->
                <select class="form-select form-select-custom" id="plano_saude_id" name="paciente[plano_saude_id]" <?= $disabledAttribute ?>>
                            <option value="">Nenhum / Particular</option>
                            <?php 
                                $planos = $aDados['planos_saude'] ?? [];
                                $plano_selecionado_id = setValor("plano_saude_id", $aDados['paciente']['plano_saude_id'] ?? '');

                                foreach ($planos as $plano):
                            ?>
                                <option value="<?= $plano['id'] ?>" <?= ($plano['id'] == $plano_selecionado_id) ? 'selected' : '' ?>>
                                    <?php // CORRIGIDO: Usa 'nome_plano' para exibir o texto da opção ?>
                                    <?= htmlspecialchars($plano['nome_plano']) ?>
                                </option>
                            <?php endforeach; ?>
                </select>
                <!-- FIM DA ALTERAÇÃO -->
            </div>
        </div>
        <div class="col-12 col-md-6">
            <label for="status" class="form-label font-semibold">Status <span class="text-danger">*</span></label>
            <select
                id="status"
                name="paciente[status]"
                class="form-select form-select-custom"
                required <?= $disabledAttribute ?>>
                <?php 
                // valores possíveis: 1 = Ativo, 0 = Inativo
                $statusAtual = (int)($aDados['paciente']['status'] ?? 1);
                ?>
                <option value="1" <?= $statusAtual === 1 ? 'selected' : '' ?>>Ativo</option>
                <option value="0" <?= $statusAtual === 0 ? 'selected' : '' ?>>Inativo</option>
            </select>
            <?= setMsgFilderError("status") ?>
        </div>


        <div class="row g-4 mt-1">
            <div class="col-12">
                <label class="form-label font-semibold">Histórico Clínico / Observações</label>
                <textarea class="form-control form-control-custom" name="paciente[historico_clinico]" rows="4" <?= $disabledAttribute ?>><?= setValor("historico_clinico", $aDados['paciente']['historico_clinico'] ?? '') ?></textarea>
            </div>
        </div>
    </div>
</div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-custom-primary btn-sm">
                <i class="bi bi-save me-2"></i> Salvar
            </button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');
    const cepFeedback = document.getElementById('cep-feedback');
    const logradouroInput = document.getElementById('logradouro');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const ufInput = document.getElementById('uf');
    const numeroInput = document.getElementById('numero');

    // Função para destravar os campos para edição manual
    function destravarCampos() {
        logradouroInput.readOnly = false;
        bairroInput.readOnly = false;
        cidadeInput.readOnly = false;
        ufInput.readOnly = false;
    }

    // Função para travar os campos após busca bem-sucedida
    function travarCampos() {
        logradouroInput.readOnly = true;
        bairroInput.readOnly = true;
        cidadeInput.readOnly = true;
        ufInput.readOnly = true;
    }

    // Função que busca o CEP (lógica que já existia)
    function buscarCep() {
        const cep = cepInput.value.replace(/\D/g, ''); // Remove tudo que não for dígito

        if (cep.length !== 8) {
            destravarCampos(); // Se o CEP for inválido, garante que os campos estejam liberados
            return;
        }

        cepFeedback.innerHTML = '<small class="text-muted">Buscando...</small>';
        
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    cepFeedback.innerHTML = '<small class="text-danger">CEP não encontrado. Digite manualmente.</small>';
                    destravarCampos();
                    logradouroInput.focus();
                } else {
                    cepFeedback.innerHTML = '';
                    logradouroInput.value = data.logradouro;
                    bairroInput.value = data.bairro;
                    cidadeInput.value = data.localidade;
                    ufInput.value = data.uf;
                    travarCampos();
                    numeroInput.focus();
                }
            })
            .catch(error => {
                cepFeedback.innerHTML = '<small class="text-danger">Erro ao buscar CEP.</small>';
                destravarCampos();
            });
    }


    if(cepInput) {
        // O listener 'blur' (quando o usuário sai do campo) continua o mesmo
        cepInput.addEventListener('blur', buscarCep);

        // ==== NOVO BLOCO DE CÓDIGO ADICIONADO ====
        // Adiciona um listener para a tecla pressionada
        cepInput.addEventListener('keydown', function(event) {
            // Verifica se a tecla pressionada foi 'Enter'
            if (event.key === 'Enter') {
                // 1. Impede o comportamento padrão (submeter o formulário)
                event.preventDefault();
                // 2. Aciona a busca do CEP, como se o usuário tivesse saído do campo
                buscarCep();
            }
        });
        // ==== FIM DO NOVO BLOCO ====
    }
});
</script>