<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Categorias <a href="/?p=admin/categories/create" class="btn" style="float:right">Novo</a></h2>
  <table class="table">
    <tr style="background:#303030"><th>ID</th><th>Nome</th><th>Ações</th></tr>
    <?php foreach($categories as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td><a href="/?p=admin/categories/edit&id=<?= $c['id'] ?>">Editar</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
