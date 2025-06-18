<?= formTitulo("Lista de Pacientes", true) ?>

<div class="m-2">
    <form method="GET" action="<?= baseUrl() ?>Paciente/index">
        <div class="row">
            <div class="col-md-4">
                <label for="filtro_status" class="form-label">Filtrar por Status</label>
                <select name="filtro_status" id="filtro_status" class="form-select">
                    <?php
                        // Obtém o filtro atual para manter a seleção no dropdown
                        $filtroAtual = $aDados['filtro_atual'] ?? 'ativos';
                    ?>
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

<?php
$listaDePacientes = $aDados['pacientes'] ?? [];
?>

<?php if (isset($listaDePacientes) && count($listaDePacientes) > 0) : ?>
    <div class="m-2">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Status</th> <th scope="col" style="width: 180px;">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaDePacientes as $paciente) : ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($paciente['id'] ?? '') ?></th>
                        <td><?= htmlspecialchars($paciente['nome'] ?? '') ?></td>
                        <td>
                            <?php if ($paciente['status'] == 1): ?>
                                <span class="badge bg-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= baseUrl() ?>Paciente/form/view/<?= htmlspecialchars($paciente['id'] ?? '') ?>" title="Visualizar" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                            <a href="<?= baseUrl() ?>Paciente/form/update/<?= htmlspecialchars($paciente['id'] ?? '') ?>" title="Alterar" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= baseUrl() ?>Paciente/form/delete/<?= htmlspecialchars($paciente['id'] ?? '') ?>" title="Excluir" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <div class="alert alert-warning mt-5 mb-5" role="alert">
        Não foram localizados pacientes com o filtro selecionado.
    </div>
<?php endif; ?>