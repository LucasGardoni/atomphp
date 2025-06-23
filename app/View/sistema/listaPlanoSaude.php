<?= formTitulo("Lista de Planos de Saúde", true) ?>

<?php if (count($aDados['planos_saude'] ?? []) > 0) : ?>
    <div class="m-2">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Plano</th>
                    <th>Contato</th>
                    <th>Telefone</th>
                    <th style="width: 150px;">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aDados['planos_saude'] as $plano) : ?>
                    <tr>
                        <td><?= $plano['id'] ?></td>
                        <td><?= htmlspecialchars($plano['nome_plano']) ?></td>
                        <td><?= htmlspecialchars($plano['contato_responsavel']) ?></td>
                        <td><?= htmlspecialchars($plano['telefone']) ?></td>
                        <td>
                            <a href="<?= baseUrl() ?>PlanoSaude/form/view/<?= $plano['id'] ?>" title="Visualizar" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                            <a href="<?= baseUrl() ?>PlanoSaude/form/update/<?= $plano['id'] ?>" title="Alterar" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= baseUrl() ?>PlanoSaude/delete/delete/<?= $plano['id'] ?>" title="Excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este plano de saúde?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <div class="alert alert-warning mt-3" role="alert">Nenhum plano de saúde cadastrado.</div>
<?php endif; ?>