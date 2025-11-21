<?php $this->layout('layouts/admin', ['title' => 'Categorias']) ?>

<?php $this->start('body') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Lista de Categorias</h4>
    <a href="/admin/categories/create" class="btn btn-primary">+ Nova Categoria</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success rounded mb-4">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif ?>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                         
                            <td><?= htmlspecialchars($cat->id) ?></td>
                            <td><?= htmlspecialchars($cat->name) ?></td>
                            <td><?= htmlspecialchars($cat->description ?? '') ?></td>
                            <td class="text-center">
                                <a href="/admin/categories/show?id=<?= htmlspecialchars($cat->id) ?>" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="/admin/categories/edit?id=<?= htmlspecialchars($cat->id) ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form method="POST" action="/admin/categories/delete" style="display:inline;">
                                    <input type="hidden" name="_csrf" value="<?= \App\Core\Csrf::token() ?>">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($cat->id) ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Excluir esta categoria?')">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Nenhuma categoria encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->stop() ?>