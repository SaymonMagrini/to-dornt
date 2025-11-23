<?php $this->layout('layouts/admin', ['title' => 'Nova Categoria']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="formView">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Nova Categoria']) ?>
    <div class="card-body">
        <form method="post" action="/admin/categories/store">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" value="<?= $this->e($old['name'] ?? '') ?>">
                    <?php if (!empty($errors['name'])): ?>
                        <div class="text-danger"><?= $this->e($errors['name']) ?></div><?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Descrição</label>
                    <input type="text" name="description" class="form-control"
                        value="<?= $this->e($old['description'] ?? '') ?>">
                    <?php if (!empty($errors['description'])): ?>
                        <div class="text-danger"><?= $this->e($errors['description']) ?></div><?php endif; ?>
                </div>
            </div>

            <?= \App\Core\Csrf::input() ?>

            <div class="d-flex gap-3">
                <button class="btn btn-success"><i class="bi bi-check-lg"></i> Salvar</button>
                <button type="reset" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Limpar</button>
                <a href="/admin/categories" class="btn"><i class="bi bi-x-lg"></i> Cancelar</a>
            </div>

        </form>
    </div>
</div>
<?php $this->stop() ?>