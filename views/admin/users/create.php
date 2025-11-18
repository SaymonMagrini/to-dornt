<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Criar Usuário</h2>
  <?php if (!empty($errors)): foreach($errors as $e): ?><p style="color:#ff6666"><?= htmlspecialchars($e) ?></p><?php endforeach; endif; ?>
  <form method="POST" action="/?p=admin/users/store">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input class="input" name="name" placeholder="Nome" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
    <input class="input" name="email" placeholder="Email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
    <input class="input" name="password" type="password" placeholder="Senha">
    <select class="input" name="role">
      <option value="user">user</option>
      <option value="admin">admin</option>
    </select>
    <button class="btn">Salvar</button>
  </form>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
