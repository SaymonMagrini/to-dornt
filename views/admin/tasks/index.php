<?php $this->layout('layouts/admin', ['title' => 'Tarefas']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Tarefas']) ?>

    <div class="card-body">

        <a href="/admin/tasks/create" class="btn btn-primary mb-3">Nova Tarefa</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= $task->id ?></td>
                        <td><?= $this->e($task->title) ?></td>
                        <td><?= $task->status ?></td>
                        <td>
                            <a href="/admin/tasks/<?= $task->id ?>" class="btn btn-sm btn-info">Ver</a>
                            <a href="/admin/tasks/<?= $task->id ?>/edit" class="btn btn-sm btn-warning">Editar</a>
                            <a href="/admin/tasks/<?= $task->id ?>/delete" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza?')">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>
</div>

<?php $this->stop() ?>
