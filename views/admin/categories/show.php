<?php $this->layout('layouts/admin', ['title' => 'Detalhe da Categoria']) ?>

<?php $this->start('body') ?>
<div class="container mt-4">
    <div class="card shadow-sm">

        <div class="card-header bg-light">
            <h5 class="mb-0">Detalhes da Categoria</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">ID:</label>
                <input class="form-control" value="<?= $this->e($category['id']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input class="form-control" value="<?= $this->e($category['name']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição:</label>
                <input class="form-control" value="<?= $this->e($category['description']) ?>" readonly>
            </div>

            <div class="text-end">
                <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
            </div>

        </div>
    </div>
</div>
<?php $this->stop() ?>