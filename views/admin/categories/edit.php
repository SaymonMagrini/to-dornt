<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Editar Categoria</h2>
  <form method="POST" action="/?p=admin/categories/update">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="id" value="<?= $category['id'] ?>">
    <input class="input" name="name" value="<?= htmlspecialchars($category['name']) ?>">
    <button class="btn">Salvar</button>
  </form>

  <form method="POST" action="/?p=admin/categories/delete" style="margin-top:10px;">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="id" value="<?= $category['id'] ?>">
    <button style="background:#ff6666;color:#fff;padding:8px;border:none;border-radius:6px">Excluir</button>
  </form>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
