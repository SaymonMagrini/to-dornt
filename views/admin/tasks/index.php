<?php $this->layout('layouts/base', ['title' => 'Tarefas']) ?>

<h2>Lista de Tarefas</h2>

<a class="btn" href="/admin/tasks/create">Nova Tarefa</a>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($tasks as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= htmlspecialchars($t['title']) ?></td>
            <td><?= htmlspecialchars($t['status']) ?></td>
            <td>
                <a class="btn" href="/admin/tasks/edit?id=<?= $t['id'] ?>">Editar</a>
                <a class="btn danger" href="/admin/tasks/delete?id=<?= $t['id'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
