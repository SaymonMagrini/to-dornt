<?php $this->layout('layouts/admin', ['title' => 'Detalhes da Tarefa']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm" id="formView">

    <?php $this->insert('partials/admin/form/header', ['title' => 'Detalhes da Tarefa']) ?>

    <div class="card-body">

        <h4><?= $this->e($task->title) ?></h4>

        <p><strong>Status:</strong> <?= $task->status ?></p>
        <p><strong>Descrição:</strong></p>

        <p><?= nl2br($this->e($task->description)) ?></p>

        <a href="/admin/tasks" class="btn btn-secondary">Voltar</a>

    </div>
</div>

<?php $this->stop() ?>
