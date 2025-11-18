<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Nova Categoria</h2>
  <form method="POST" action="/?p=admin/categories/store">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input class="input" name="name" placeholder="Nome">
    <button class="btn">Salvar</button>
  </form>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
