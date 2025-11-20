<?php $this->layout('layouts/admin', ['title' => 'Tags']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="tableView">

    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Lista de Tags</h5>
        <a href="/admin/tags/create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nova Tag
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($tags as $tag): ?>
                    <tr>
                        <td><?= $this->e($tag['id']) ?></td>
                        <td><?= $this->e($tag['name']) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a class="btn btn-sm btn-secondary"
                                   href="/admin/tags/show?id=<?= $this->e($tag['id']) ?>">
                                    <i class="bi bi-eye"></i> Ver
                                </a>

                                <a class="btn btn-sm btn-primary"
                                   href="/admin/tags/edit?id=<?= $this->e($tag['id']) ?>">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>

                                <form action="/admin/tags/delete" method="post" class="d-inline"
                                    onsubmit="return confirm('Excluir tag <?= $this->e($tag['name']) ?>?');">

                                    <input type="hidden" name="id" value="<?= $this->e($tag['id']) ?>">
                                    <?= \App\Core\Csrf::input() ?>

                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>

                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php $this->stop() ?>