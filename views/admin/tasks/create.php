<?php $this->layout('layouts/admin', ['title' => 'Nova Task']) ?>

<?php $this->start('body') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Nova Task</h4>
    <a href="/admin/tasks" class="btn btn-secondary">Voltar</a>
</div>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="/admin/tasks/store">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">

            <div class="mb-3">
                <label class="form-label">Título *</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select">
                    <option value="">Sem categoria</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($old['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Prazo</label>
                <input type="date" name="due_date" class="form-control" value="<?= $old['due_date'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Tags</label>
                <select name="tag_ids[]" class="form-select" multiple size="5">
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $selectedTagIds) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tag['name']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <div class="form-text">Segure Ctrl (ou Cmd) para selecionar várias</div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    Criar Task
                </button>
            </div>
        </form>
    </div>
</div>

<?php $this->stop() ?>