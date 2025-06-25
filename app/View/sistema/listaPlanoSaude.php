<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/form.css">
<div class="space-y-6 container py-4">

    <div class="d-flex align-items-center mb-4">
    <a href="<?= baseUrl() ?>PlanoSaude/form/insert" class="btn btn-primary btn-sm me-3">
    <i class="bi bi-plus-circle me-2"></i> Adicionar Novo
</a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-0">Lista de Planos de Saúde</h1>
            <p class="text-muted mb-0">Gerencie os planos de saúde cadastrados no sistema.</p>
        </div>
    </div>

    <?php if (count($aDados['planos_saude'] ?? []) > 0) : ?>
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3">
                <h5 class="card-title fw-bold mb-0">Planos Cadastrados</h5>
            </div>
            <div class="card-body p-0"> <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col">Nome do Plano</th>
                                <th scope="col">Contato</th>
                                <th scope="col">Telefone</th>
                                <th scope="col" class="text-center" style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aDados['planos_saude'] as $plano) : ?>
                                <tr>
                                    <td class="text-center"><?= $plano['id'] ?></td>
                                    <td><?= htmlspecialchars($plano['nome_plano']) ?></td>
                                    <td><?= htmlspecialchars($plano['contato_responsavel']) ?></td>
                                    <td><?= htmlspecialchars($plano['telefone']) ?></td>
                                    <td class="text-center">
                                        <a href="<?= baseUrl() ?>PlanoSaude/form/view/<?= $plano['id'] ?>" title="Visualizar" class="btn btn-info btn-sm me-1">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= baseUrl() ?>PlanoSaude/form/update/<?= $plano['id'] ?>" title="Alterar" class="btn btn-primary btn-sm me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= baseUrl() ?>PlanoSaude/delete/delete/<?= $plano['id'] ?>" title="Excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este plano de saúde? Esta ação é irreversível.')">
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
        <div class="alert alert-warning mt-4 text-center" role="alert">
            <h4 class="alert-heading">Nenhum plano de saúde cadastrado!</h4>
            <p>Clique em "Adicionar Novo" para começar a gerenciar seus planos de saúde.</p>
        </div>
    <?php endif; ?>

</div>

<?php limpaDadosSessao(); ?>