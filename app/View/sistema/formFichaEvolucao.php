<?php
// Pega as informações da sessão para exibir no título
$sessaoInfo = $aDados['sessao_info'] ?? null;
$titulo = "Ficha de Evolução";
if ($sessaoInfo) {
    $titulo .= " - Paciente: " . htmlspecialchars($sessaoInfo['nome_paciente']);
    $titulo .= " | Data: " . date('d/m/Y H:i', strtotime($sessaoInfo['data_hora_agendamento']));
}
?>

<?= formTitulo($titulo) ?>

<div class="m-2">
    <form method="POST" action="<?= baseUrl() ?>FichaEvolucao/save">

        <input type="hidden" name="id" value="<?= setValor("id", $aDados['ficha_evolucao']['id'] ?? '') ?>">
        
        <input type="hidden" name="sessao_id" value="<?= htmlspecialchars($sessaoInfo['id']) ?>">

        <div class="mb-3">
            <label for="descricao_evolucao" class="form-label">
                <h5>Descrição da Evolução Clínica <span class="text-danger">*</span></h5>
                <small class="text-muted">Descreva o que foi feito na sessão, a evolução do paciente, dificuldades encontradas, etc.</small>
            </label>
            <textarea class="form-control" id="descricao_evolucao" name="descricao_evolucao" rows="10" required><?= setValor("descricao_evolucao", $aDados['ficha_evolucao']['descricao_evolucao'] ?? '') ?></textarea>
            <?= setMsgFilderError("descricao_evolucao") ?>
        </div>

        <div class="mb-3">
            <label for="recomendacoes" class="form-label">
                <h5>Recomendações</h5>
                <small class="text-muted">Instruções e recomendações para o paciente fazer em casa.</small>
            </label>
            <textarea class="form-control" id="recomendacoes" name="recomendacoes" rows="5"><?= setValor("recomendacoes", $aDados['ficha_evolucao']['recomendacoes'] ?? '') ?></textarea>
        </div>

        <?= formButton() ?>
    </form>
</div>

<?php limpaDadosSessao(); ?>