<?php $this->layout('layouts/base', ['title' => 'Categorias']) ?>

<h2>Categorias</h2>

<a class="btn" href="/admin/categories/create">Nova Categoria</a>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($categories as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td>
                <a class="btn" href="/admin/categories/edit?id=<?= $c['id'] ?>">Editar</a>
                <a class="btn danger" href="/admin/categories/delete?id=<?= $c['id'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
