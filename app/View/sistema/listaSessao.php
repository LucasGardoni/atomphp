<?= formTitulo("Agenda de Sessões", true) ?>

<?php $listaDeSessoes = $aDados['sessoes'] ?? []; ?>

<?php if (count($listaDeSessoes) > 0) : ?>
    <div class="m-2">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Fisioterapeuta</th>
                    <th>Data e Hora</th>
                    <th>Status</th>
                    <th style="width: 210px;">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaDeSessoes as $sessao) : ?>
                    <tr>
                        <td><?= htmlspecialchars($sessao['nome_paciente']) ?></td>
                        <td><?= htmlspecialchars($sessao['nome_fisioterapeuta']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($sessao['data_hora_agendamento'])) ?></td>
                        <td><span class="badge bg-info"><?= htmlspecialchars($sessao['status_sessao']) ?></span></td>
                        <td>
                            <a href="<?= baseUrl() ?>FichaEvolucao/form/insert/<?= $sessao['id'] ?>" title="Ficha de Evolução" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-text"></i> Evolução</a>
                            <a href="<?= baseUrl() ?>Sessao/form/view/<?= $sessao['id'] ?>" title="Visualizar" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                            <a href="<?= baseUrl() ?>Sessao/form/update/<?= $sessao['id'] ?>" title="Alterar" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <div class="alert alert-warning mt-5 mb-5" role="alert">
        Nenhuma sessão agendada.
    </div>
<?php endif; ?>