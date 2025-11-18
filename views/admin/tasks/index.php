<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Todas as Tarefas</h2>
  <table class="table">
    <tr style="background:#303030"><th>ID</th><th>Título</th><th>Usuário</th><th>Concluída</th><th>Ações</th></tr>
    <?php foreach($tasks as $t): ?>
      <tr>
        <td><?= $t['id'] ?></td>
        <td><?= htmlspecialchars($t['title']) ?></td>
        <td><?= htmlspecialchars($t['user_name'] ?? '') ?></td>
        <td><?= $t['done'] ? 'Sim' : 'Não' ?></td>
        <td><a href="/?p=admin/tasks/edit&id=<?= $t['id'] ?>">Editar</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
