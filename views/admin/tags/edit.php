<?php $this->layout('layouts/admin', ['title' => 'Editar Tag']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="formView">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Editar Tag']) ?>
    <div class="card-body">

        <form method="post" action="/admin/tags/update">
            <input type="hidden" name="id" value="<?= $this->e($tag['id']) ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= $this->e($tag['name']) ?>" required>
                    <?php if (!empty($errors['name'])): ?>
                        <div class="text-danger"><?= $this->e($errors['name']) ?></div><?php endif; ?>
                </div>
            </div>

            <?= \App\Core\Csrf::input() ?>

            <div class="d-flex gap-3">
                <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Atualizar</button>
                <button type="reset" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Limpar</button>
                <a href="/admin/tags" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>

        </form>
    </div>
</div>
<?php $this->stop() ?>