<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Usuários <a href="/?p=admin/users/create" class="btn" style="float:right">Novo</a></h2>
  <table class="table">
    <tr style="background:#303030"><th>ID</th><th>Nome</th><th>Email</th><th>Role</th><th>Ações</th></tr>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td><a href="/?p=admin/users/edit&id=<?= $u['id'] ?>">Editar</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
