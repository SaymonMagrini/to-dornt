<?php $this->layout('layouts/admin', ['title' => 'Editar Tarefa']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm" id="formView">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Editar Tarefa']) ?>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="card-body">
        <form action="/admin/tasks/update" method="post">
            <input type="hidden" name="id" value="<?= $task['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Título *</label>
                <input type="text" name="name" class="form-control"
                       value="<?= $this->e($old['name'] ?? $task['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="4">
                    <?= $this->e($old['description'] ?? $task['description'] ?? '') ?>
                </textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select">
                    <option value="">Sem categoria</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= ($old['category_id'] ?? $task['category_id']) == $cat['id'] ? 'selected' : '' ?>>
                            <?= $this->e($cat['name']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Prazo</label>
                <input type="date" name="due_date" class="form-control"
                       value="<?= $old['due_date'] ?? $task['due_date'] ?? '' ?>">
            </div>

            <div class="mb-3">
    <label class="form-label">Tags</label>
    <select name="tag_ids[]" class="form-select" multiple>
        <?php foreach ($tags as $tag): ?>
            <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $selectedTagIds) ? 'selected' : '' ?>>
                <?= $this->e($tag['name']) ?>
            </option>
        <?php endforeach ?>
    </select>
    <div class="form-text">Segure Ctrl para selecionar várias</div>
</div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="done" class="form-select">
                    <option value="0" <?= empty($old['done'] ?? $task['done']) ? 'selected' : '' ?>>Pendente</option>
                    <option value="1" <?= !empty($old['done'] ?? $task['done']) ? 'selected' : '' ?>>Concluída</option>
                </select>
            </div>

            <?= \App\Core\Csrf::input() ?>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="/admin/tasks" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php $this->stop() ?>