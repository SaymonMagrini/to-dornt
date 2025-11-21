<?php $this->layout('layouts/admin', ['title' => 'Tasks']) ?>

<?php $this->start('body') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Lista de Tasks</h4>
    <a href="/admin/tasks/create" class="btn btn-primary">+ Nova Task</a>
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
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Prazo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= $task['id'] ?></td>
                        <td><?= htmlspecialchars($task['title'] ?? $task['name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($task['description'] ?? '') ?></td>
                        <td>
                            <?php if (!empty($task['category_id'])): ?>
                                <span class="text-primary">CAT <?= $task['category_id'] ?></span>
                            <?php else: ?>—<?php endif ?>
                        </td>
                        <td>
                            <?php if (!empty($task['due_date'])): ?>
                                <?= (new DateTime($task['due_date']))->format('d/m/Y') ?>
                            <?php else: ?>—<?php endif ?>
                        </td>
                        <td>
                            <?php if (!empty($task['done'])): ?>
                                <span class="badge bg-success">Concluída</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pendente</span>
                            <?php endif ?>
                        </td>
                        <td class="text-center">
                            <a href="/admin/tasks/show?id=<?= $task['id'] ?>" class="btn btn-sm btn-secondary">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="/admin/tasks/edit?id=<?= $task['id'] ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form method="POST" action="/admin/tasks/delete" style="display:inline">
                                <input type="hidden" name="_csrf" value="<?= \App\Core\Csrf::token() ?>">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->stop() ?>