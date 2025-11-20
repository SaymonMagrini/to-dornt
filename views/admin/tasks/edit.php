<?php $this->layout('layouts/admin', ['title' => 'Editar Tarefa']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm" id="formView">

    <?php $this->insert('partials/admin/form/header', ['title' => 'Editar Tarefa']) ?>

    <div class="card-body">

        <form action="/admin/tasks/<?= $task->id ?>/update" method="post">

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" class="form-control" name="title"
                       value="<?= $this->e($task->title) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control">
                    <?= $this->e($task->description) ?>
                </textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="pendente" <?= $task->status === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="concluida" <?= $task->status === 'concluida' ? 'selected' : '' ?>>Concluída</option>
                </select>
            </div>

            <?= \App\Core\Csrf::input() ?>

            <button class="btn btn-success">Salvar</button>
            <a href="/admin/tasks" class="btn btn-secondary">Cancelar</a>
        </form>

    </div>
</div>

<?php $this->stop() ?>
