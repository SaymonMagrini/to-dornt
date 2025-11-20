<?php $this->layout('layouts/admin', ['title' => 'Detalhe da Tag']) ?>

<?php $this->start('body') ?>
<div class="container mt-4">
    <div class="card shadow-sm">

        <div class="card-header bg-light">
            <h5 class="mb-0">Detalhes da Tag</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">ID:</label>
                <input class="form-control" value="<?= $this->e($tag['id']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input class="form-control" value="<?= $this->e($tag['name']) ?>" readonly>
            </div>
            
            <div class="text-end">
                <a href="javascript:history.back()" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
            </div>

        </div>
    </div>
</div>
<?php $this->stop() ?>