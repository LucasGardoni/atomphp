<?= formTitulo("Lista de Fisioterapeutas", true) ?>

<div class="m-2">
    <form method="GET" action="<?= baseUrl() ?>Fisioterapeuta/index">
        <div class="row">
            <div class="col-md-4">
                <label for="filtro_status" class="form-label">Filtrar por Status</label>
                <select name="filtro_status" id="filtro_status" class="form-select">
                    <?php $filtroAtual = $aDados['filtro_atual'] ?? 'ativos'; ?>
                    <option value="ativos" <?= $filtroAtual === 'ativos' ? 'selected' : '' ?>>Apenas Ativos</option>
                    <option value="inativos" <?= $filtroAtual === 'inativos' ? 'selected' : '' ?>>Apenas Inativos</option>
                    <option value="todos" <?= $filtroAtual === 'todos' ? 'selected' : '' ?>>Todos</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>
</div>
<hr>

<?php $listaDeFisioterapeutas = $aDados['fisioterapeutas'] ?? []; ?>

<?php if (count($listaDeFisioterapeutas) > 0) : ?>
    <div class="m-2">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CREFITO</th>
                    <th scope="col">Status</th>
                    <th scope="col" style="width: 180px;">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaDeFisioterapeutas as $fisio) : ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($fisio['id']) ?></th>
                        <td><?= htmlspecialchars($fisio['nome']) ?></td>
                        <td><?= htmlspecialchars($fisio['crefito']) ?></td>
                        <td>
                            <?= $fisio['status'] == 1 ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-danger">Inativo</span>' ?>
                        </td>
                        <td>
                        <a href="<?= baseUrl() ?>HorarioTrabalho/index/index/<?= $fisio['id'] ?>" title="Gerenciar Horários" class="btn btn-secondary btn-sm"><i class="bi bi-clock-fill"></i> Horários</a>
                            <a href="<?= baseUrl() ?>Fisioterapeuta/form/view/<?= $fisio['id'] ?>" title="Visualizar" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                            <a href="<?= baseUrl() ?>Fisioterapeuta/form/update/<?= $fisio['id'] ?>" title="Alterar" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= baseUrl() ?>Fisioterapeuta/form/delete/<?= $fisio['id'] ?>" title="Excluir" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <div class="alert alert-warning mt-5 mb-5" role="alert">
        Não foram localizados fisioterapeutas com o filtro selecionado.
    </div>
<?php endif; ?>