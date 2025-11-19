<?php $this->layout('layouts/admin', ['title' => 'Tags']) ?>

<h2>Tags</h2>

<a class="btn" href="/admin/tags/create">Nova Categoria</a>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($tags as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td>
                <a class="btn" href="/admin/tags/edit?id=<?= $c['id'] ?>">Editar</a>
                <a class="btn danger" href="/admin/tags/delete?id=<?= $c['id'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
