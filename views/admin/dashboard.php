<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container">
  <h1 style="color:#00FFFF">Painel Admin</h1>
  <p>Bem-vindo, <?= htmlspecialchars($user['name'] ?? 'Admin') ?></p>
  <ul>
    <li><a href="/?p=admin/users">Usuários</a></li>
    <li><a href="/?p=admin/categories">Categorias</a></li>
    <li><a href="/?p=admin/tasks">Tarefas</a></li>
  </ul>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
