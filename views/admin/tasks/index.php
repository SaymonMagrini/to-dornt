<?php $this->layout('layouts/admin', ['title' => 'Tasks']) ?>

<?php $this->start('body') ?>

<div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
    <h5 class="mb-0 fw-semibold">Lista de Tarefas</h5>
    <a href="/admin/tasks/create" class="btn btn-primary">+ Nova Tarefa</a>
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
                    <th>Categoria</th>
                    <th>Tags</th>
                    <th>Prazo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= $task['id'] ?></td>
                        <td><?= htmlspecialchars($task['name'] ?? $task['name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($task['description'] ?? '') ?></td>
                        <td>
                            <?php if (!empty($task['category_id'])): ?>
                                <span class="fw-semibold text-primary">
                                    <?= htmlspecialchars($task['category_name']) ?>
                                </span>
                            <?php else: ?>
                                —
                            <?php endif ?>

                        </td>
                        <td>
                            <?php if (!empty($task['tags'])): ?>
                                <?php foreach ($task['tags'] as $tag): ?>
                                    <span class="badge bg-info text-dark"><?= htmlspecialchars($tag['name']) ?></span>
                                <?php endforeach ?>
                            <?php else: ?>
                                —
                            <?php endif ?>
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

<div class="pagination" style="margin-top:12px;">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php if ($i == $page): ?>
            <strong>[<?= $i ?>]</strong>
        <?php else: ?>
            <a href="/admin/tags?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
</div>


<?php $this->stop() ?>