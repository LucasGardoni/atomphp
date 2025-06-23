<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/lista.css">
<?php
$fisioterapeutaNome = $aDados['subtitulo'] ?? 'Fisioterapeuta';
$formTitle = $aDados['titulo'] ?? 'Horários de Trabalho';
$pageTitle = $formTitle . ' - ' . htmlspecialchars($fisioterapeutaNome);
?>

<div class="space-y-6 container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= baseUrl() ?>Fisioterapeuta/index" class="btn btn-custom-primary btn-sm me-3">
            <i class="bi bi-arrow-left me-2"></i> Voltar para Fisioterapeutas
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= $pageTitle ?></h1>
            <p class="text-muted">Gerencie os blocos de horários de atendimento de <?= htmlspecialchars($fisioterapeutaNome) ?>.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Blocos de Horário Registrados</h5>
            <a href="<?= baseUrl() ?>HorarioTrabalho/form/insert/<?= $aDados['fisioterapeuta_id'] ?>" class="btn btn-custom-primary btn-sm">
                <i class="bi bi-plus-lg me-2"></i> Adicionar Horário
            </a>
        </div>
        <div class="card-body p-0"> <?php if (empty($aDados['horarios'])): ?>
                <div class="p-4 text-center text-muted">
                    <p class="mb-0">Nenhum bloco de horário cadastrado para este fisioterapeuta.</p>
                    <p>Clique em "Adicionar Horário" para começar.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="py-3 ps-4">Dia da Semana</th>
                                <th scope="col" class="py-3">Início</th>
                                <th scope="col" class="py-3">Fim</th>
                                <th scope="col" class="py-3 text-center pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $dias = [
                                1 => 'Segunda-feira',
                                2 => 'Terça-feira',
                                3 => 'Quarta-feira',
                                4 => 'Quinta-feira',
                                5 => 'Sexta-feira',
                                6 => 'Sábado',
                                7 => 'Domingo'
                            ];
                            foreach ($aDados['horarios'] as $horario):
                            ?>
                                <tr>
                                    <td class="ps-4"><?= $dias[$horario['dia_semana']] ?></td>
                                    <td><?= date('H:i', strtotime($horario['hora_inicio'])) ?></td>
                                    <td><?= date('H:i', strtotime($horario['hora_fim'])) ?></td>
                                    <td class="text-center">
                                        <a href="<?= baseUrl() ?>HorarioTrabalho/form/update/<?= $horario['id'] ?>" class="btn btn-sm btn-outline-primary me-2" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= baseUrl() ?>HorarioTrabalho/delete/<?= $horario['id'] ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este horário? Esta ação não pode ser desfeita.');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php limpaDadosSessao(); ?>