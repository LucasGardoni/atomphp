<?= formTitulo("Lista de Especialidades", true) ?>

<?php if (count($aDados['especialidades'] ?? []) > 0) : ?>
    <div class="m-2">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th style="width: 150px;">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aDados['especialidades'] as $especialidade) : ?>
                    <tr>
                        <td><?= $especialidade['id'] ?></td>
                        <td><?= htmlspecialchars($especialidade['nome']) ?></td>
                        <td>
                            <a href="<?= baseUrl() ?>Especialidade/form/view/<?= $especialidade['id'] ?>" title="Visualizar" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                            <a href="<?= baseUrl() ?>Especialidade/form/update/<?= $especialidade['id'] ?>" title="Alterar" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= baseUrl() ?>Especialidade/delete/delete/<?= $especialidade['id'] ?>" title="Excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta especialidade?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <div class="alert alert-warning mt-3" role="alert">Nenhuma especialidade cadastrada.</div>
<?php endif; ?>