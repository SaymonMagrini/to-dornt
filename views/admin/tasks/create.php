<?php $this->layout('layouts/admin', ['title' => 'Nova Tarefa']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm" id="formView">

    <?php $this->insert('partials/admin/form/header', ['title' => 'Nova Tarefa']) ?>

    <div class="card-body">
        <form action="/admin/tasks/store" method="post">

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" class="form-control" name="title" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <?= \App\Core\Csrf::input() ?>

            <button class="btn btn-success">Criar</button>
            <a href="/admin/tasks" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>

<?php $this->stop() ?>
