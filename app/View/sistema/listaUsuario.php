<link rel="stylesheet" href="<?= baseUrl() ?>assets/css/lista.css">
<?php

use Core\Library\Session;

$aNivel = ["1" => "Super Administrador", "11" => "Administrador", "21" => "Usuário"];
$aStatus = ["1" => "Ativo", "2" => "Inativo", "3" => "Bloqueado"];

?>

<div class="space-y-6 container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Lista de Usuários</h1>
            <p class="text-muted">Gerencie os usuários do sistema</p>
        </div>
        <a href="<?= baseUrl() ?>Usuario/form/insert/0" class="btn btn-custom-primary">
            <i class="bi bi-plus-lg me-2"></i> Adicionar Novo
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mt-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0">Usuários Cadastrados</h5>
        </div>
        <div class="card-body p-0">
            <?php if (count($dados) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3 px-4">ID</th>
                                <th scope="col" class="py-3 px-4">Nome</th>
                                <th scope="col" class="py-3 px-4">Email</th>
                                <th scope="col" class="py-3 px-4">Nível</th>
                                <th scope="col" class="py-3 px-4 text-center">Status</th>
                                <th scope="col" class="py-3 px-4 text-center">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dados as $value): ?>
                                <tr class="hover-bg-gray-50">
                                    <th scope="row" class="py-3 px-4 font-medium text-gray-800"><?= htmlspecialchars($value['id'] ?? '') ?></th>
                                    <td class="py-3 px-4 text-base text-gray-800"><?= htmlspecialchars($value['nome'] ?? '') ?></td>
                                    <td class="py-3 px-4 text-base text-gray-800"><?= htmlspecialchars($value['email'] ?? '') ?></td>
                                    <td class="py-3 px-4 text-base text-gray-800"><?= htmlspecialchars($aNivel[$value['nivel']] ?? 'N/A') ?></td>
                                    <td class="py-3 px-4 text-center">
                                        <?php
                                        $badgeClass = 'badge-inactive'; // Padrão para inativo/bloqueado
                                        $statusText = htmlspecialchars($aStatus[$value['statusRegistro']] ?? 'Desconhecido');

                                        if (($value['statusRegistro'] ?? '') == 1) {
                                            $badgeClass = 'badge-active';
                                        } else if (($value['statusRegistro'] ?? '') == 3) {
                                            $badgeClass = 'badge-blocked';
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="d-flex justify-content-center space-x-3">
                                            <a href="<?= baseUrl() ?>Usuario/form/view/<?= htmlspecialchars($value['id'] ?? '') ?>" title="Visualizar" class="action-icon-link text-blue-500">
                                                <i class="bi bi-eye w-5 h-5"></i>
                                            </a>
                                            <a href="<?= baseUrl() ?>Usuario/form/update/<?= htmlspecialchars($value['id'] ?? '') ?>" title="Alterar" class="action-icon-link text-indigo-500">
                                                <i class="bi bi-pencil-square w-5 h-5"></i>
                                            </a>
                                            <a href="<?= baseUrl() ?>Usuario/form/delete/<?= htmlspecialchars($value['id'] ?? '') ?>" title="Excluir" class="action-icon-link text-red-500">
                                                <i class="bi bi-trash w-5 h-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert-custom-warning my-4 mx-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg class="w-6 h-6 me-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2-98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clipRule="evenodd" />
                        </svg>
                        <div>
                            <strong class="font-bold">Nenhum Usuário Encontrado!</strong>
                            <div class="mt-1">Não foram localizados usuários cadastrados.</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>