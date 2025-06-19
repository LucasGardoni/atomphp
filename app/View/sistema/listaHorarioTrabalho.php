<?= formTitulo($aDados['titulo'] . ' - ' . $aDados['subtitulo'], false) ?>

<div class="m-2">
    <a href="<?= baseUrl() ?>HorarioTrabalho/form/insert/<?= $aDados['fisioterapeuta_id'] ?>" class="btn btn-success mb-3"><i class="bi bi-plus-lg"></i> Adicionar Bloco de Horário</a>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Dia da Semana</th>
                <th>Início</th>
                <th>Fim</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $dias = [1 => 'Segunda-feira', 2 => 'Terça-feira', 3 => 'Quarta-feira', 4 => 'Quinta-feira', 5 => 'Sexta-feira', 6 => 'Sábado', 7 => 'Domingo'];
            foreach ($aDados['horarios'] ?? [] as $horario): 
            ?>
                <tr>
                    <td><?= $dias[$horario['dia_semana']] ?></td>
                    <td><?= date('H:i', strtotime($horario['hora_inicio'])) ?></td>
                    <td><?= date('H:i', strtotime($horario['hora_fim'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>