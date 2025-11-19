<?php $title = "Usuários"; ?>

<h2>Usuários</h2>

<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
    </tr>

    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
