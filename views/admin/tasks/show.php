<?php $this->layout('layouts/admin', ['title' => 'Detalhes da Tarefa']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm" id="formView">

    <?php $this->insert('partials/admin/form/header', ['title' => 'Detalhes da Tarefa']) ?>

    <div class="card-body">

        <h4><?= $this->e($task->title) ?></h4>

        <div class="mb-3">
            <label class="form-label">ID:</label>
            <input class="form-control" value="<?= $this->e($task['id']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input class="form-control" value="<?= $this->e($task['name']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição:</label>
            <input class="form-control" value="<?= $this->e($task['description']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria:</label>
            <input class="form-control" value="<?= $this->e($task['category_name'] ?? '—') ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Tags:</label> <br>
            <?php if (!empty($task['tags'])): ?>
                <?php foreach ($task['tags'] as $tag): ?>
                    <span class="badge bg-info text-dark"><?= htmlspecialchars($tag['name']) ?></span>
                <?php endforeach ?>
            <?php else: ?>
                —
            <?php endif ?>

        </div>

        <div class="mb-3">
            <label class="form-label">Status:</label>
            <?php if (($task['done'])): ?>
                <span class="badge bg-success">Concluída</span>
            <?php else: ?>
                <span class="badge bg-warning text-dark">Pendente</span>
            <?php endif ?>
        </div>



        <p><?= nl2br($this->e($task->description)) ?></p>

        <a href="/admin/tasks" class="btn btn-secondary">Voltar</a>

    </div>
</div>

<?php $this->stop() ?>