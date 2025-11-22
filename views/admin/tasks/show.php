<?php $this->layout('layouts/admin', ['title' => 'Detalhes da Tarefa']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm" id="formView">

    <?php $this->insert('partials/admin/form/header', ['title' => 'Detalhes da Tarefa']) ?>

    <div class="card-body">

        <h4><?= $this->e($task->title) ?></h4>

        <div class="mb-3">
            <label class="form-label">Status:</label>
            <input class="form-control" value="<?= $this->e($task['done']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição:</label>
            <input class="form-control" value="<?= $this->e($task['description']) ?>" readonly>
        </div>

        <p><?= nl2br($this->e($task->description)) ?></p>

        <a href="/admin/tasks" class="btn btn-secondary">Voltar</a>

    </div>
</div>

<?php $this->stop() ?>