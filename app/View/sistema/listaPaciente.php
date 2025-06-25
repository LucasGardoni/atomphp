<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/lista.css">


<div class="space-y-6 container py-4">
    <?= exibeAlerta() ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Lista de Pacientes</h1>
            <p class="text-muted">Gerencie os pacientes da clínica</p>
        </div>
        <a href="<?= baseUrl() ?>Paciente/form/insert/0" class="btn btn-custom-primary">
            <i class="bi bi-plus-lg me-2"></i> Adicionar Novo
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Filtros</h5>
        </div>
        <div class="card-body py-4">
            <form method="GET" action="<?= baseUrl() ?>Paciente/index">
                <div class="row g-4 align-items-end">
                    <div class="col-12 col-md-4 col-lg-4">
                        <label for="filtro_status" class="form-label text-sm font-semibold text-gray-800 mb-2">
                            Filtrar por Status
                        </label>
                        <select name="filtro_status" id="filtro_status" class="form-select form-select-custom">
                            <?php
                            $filtroAtual = $aDados['filtro_atual'] ?? 'ativos';
                            ?>
                            <option value="ativos" <?= $filtroAtual === 'ativos' ? 'selected' : '' ?>>Apenas Ativos</option>
                            <option value="inativos" <?= $filtroAtual === 'inativos' ? 'selected' : '' ?>>Apenas Inativos</option>
                            <option value="todos" <?= $filtroAtual === 'todos' ? 'selected' : '' ?>>Todos</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-custom-primary w-100">
                            <i class="bi bi-funnel me-2 "></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mt-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Pacientes Cadastrados</h5>
        </div>
        <div class="card-body p-0"> <?php
                                    $listaDePacientes = $aDados['pacientes'] ?? [];
                                    ?>

            <?php if (isset($listaDePacientes) && count($listaDePacientes) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3 px-4">ID</th>
                                <th scope="col" class="py-3 px-4">Nome</th>
                                <th scope="col" class="py-3 px-4">Status</th>
                                <th scope="col" class="py-3 px-4 text-center">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaDePacientes as $paciente) : ?>
                                <tr class="hover-bg-gray-50">
                                    <th scope="row" class="py-3 px-4 font-medium text-gray-800"><?= htmlspecialchars($paciente['id'] ?? '') ?></th>
                                    <td class="py-3 px-4 text-base text-gray-800"><?= htmlspecialchars($paciente['nome'] ?? '') ?></td>
                                    <td class="py-3 px-4">
                                        <?php if (($paciente['status'] ?? '') == 1): ?>
                                            <span class="badge badge-active">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge badge-inactive">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="d-flex justify-content-center space-x-3">
                                            <a href="<?= baseUrl() ?>Paciente/form/view/<?= htmlspecialchars($paciente['id'] ?? '') ?>" title="Visualizar" class="action-icon-link text-blue-500">
                                                <i class="bi bi-eye w-5 h-5"></i>
                                            </a>
                                            <a href="<?= baseUrl() ?>Paciente/form/update/<?= htmlspecialchars($paciente['id'] ?? '') ?>" title="Alterar" class="action-icon-link text-indigo-500">
                                                <i class="bi bi-pencil-square w-5 h-5"></i>
                                            </a>
                                            <a href="<?= baseUrl() ?>Paciente/delete/delete/<?= htmlspecialchars($paciente['id'] ?? '') ?>" title="Excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este paciente? A ação não poderá ser desfeita.');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="alert-custom-warning my-4 mx-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg class="w-6 h-6 me-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2-98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clipRule="evenodd" />
                        </svg>
                        <div>
                            <strong class="font-bold">Nenhum Paciente Encontrado!</strong>
                            <div class="mt-1">Não foram localizados pacientes com o filtro selecionado.</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>