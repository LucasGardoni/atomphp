<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/formSessao.css">

<div class="space-y-6 container py-4">
    <?= exibeAlerta() ?>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Agenda de Sessões</h1>
            <p class="text-muted">Gerencie os agendamentos das sessões.</p>
        </div>
        <a href="<?= baseUrl() ?>Sessao/form/insert/0" class="btn btn-custom-primary">
            <i class="bi bi-plus-lg me-2"></i> Nova Sessão
        </a>
    </div>

    <?php $listaDeSessoes = $aDados['sessoes'] ?? []; ?>

    <?php if (count($listaDeSessoes) > 0) : ?>
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body py-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped custom-table">
                        <thead>
                            <tr>
                                <th class="text-sm font-semibold text-gray-800">Paciente</th>
                                <th class="text-sm font-semibold text-gray-800">Fisioterapeuta</th>
                                <th class="text-sm font-semibold text-gray-800">Data e Hora</th>
                                <th class="text-sm font-semibold text-gray-800">Status</th>
                                <th class="text-sm font-semibold text-gray-800 text-center" style="width: 240px;">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaDeSessoes as $sessao) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($sessao['nome_paciente']) ?></td>
                                    <td><?= htmlspecialchars($sessao['nome_fisioterapeuta']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($sessao['data_hora_agendamento'])) ?></td>
                                    <td><span class="badge bg-<?= getStatusBadgeClass($sessao['status_sessao']) ?>"><?= htmlspecialchars($sessao['status_sessao']) ?></span></td>
                                    <td class="text-center d-flex gap-2 justify-content-center">
                                        <a href="<?= baseUrl() ?>FichaEvolucao/form/insert/<?= $sessao['id'] ?>" title="Ficha de Evolução" class="btn btn-sm btn-outline-success custom-btn-icon">
                                            <i class="bi bi-file-earmark-text"></i> <span class="d-none d-md-inline">Evolução</span>
                                        </a>
                                        <a href="<?= baseUrl() ?>Sessao/form/view/<?= $sessao['id'] ?>" title="Visualizar" class="btn btn-sm btn-outline-info custom-btn-icon">
                                            <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Visualizar</span>
                                        </a>
                                        <a href="<?= baseUrl() ?>Sessao/form/update/<?= $sessao['id'] ?>" title="Alterar" class="btn btn-sm btn-outline-primary custom-btn-icon">
                                            <i class="bi bi-pencil-square"></i> <span class="d-none d-md-inline">Editar</span>
                                        </a>
                                        <a href="<?= baseUrl() ?>Sessao/delete/delete/<?= $sessao['id'] ?>" title="Excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta sessão? A ação não poderá ser desfeita.');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="alert-custom-info">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle me-3 w-6 h-6"></i>
                <div>
                    <strong class="font-bold">Nenhuma sessão agendada!</strong>
                    <div class="mt-1">
                        Comece adicionando a <a href="<?= baseUrl() ?>Sessao/form/insert/0" class="text-decoration-none fw-bold">primeira sessão</a>.
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
function getStatusBadgeClass(string $status): string
{
    switch (strtolower($status)) {
        case 'agendada':
            return 'primary';
        case 'realizada':
            return 'success';
        case 'cancelada':
            return 'danger';
        case 'confirmada':
            return 'info';
        case 'pendente':
            return 'warning text-dark';
        default:
            return 'secondary';
    }
}
?>