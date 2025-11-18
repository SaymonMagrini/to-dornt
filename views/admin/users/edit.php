<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Editar Usuário</h2>
  <?php if (!empty($errors)): foreach($errors as $e): ?><p style="color:#ff6666"><?= htmlspecialchars($e) ?></p><?php endforeach; endif; ?>
  <form method="POST" action="/?p=admin/users/update">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">
    <input class="input" name="name" value="<?= htmlspecialchars($user['name']) ?>">
    <input class="input" name="email" value="<?= htmlspecialchars($user['email']) ?>">
    <input class="input" name="password" type="password" placeholder="Nova senha (opcional)">
    <select class="input" name="role">
      <option value="user" <?= ($user['role'] ?? '')==='user' ? 'selected' : '' ?>>user</option>
      <option value="admin" <?= ($user['role'] ?? '')==='admin' ? 'selected' : '' ?>>admin</option>
    </select>
    <button class="btn">Atualizar</button>
  </form>

  <form method="POST" action="/?p=admin/users/delete" style="margin-top:12px;">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">
    <button style="background:#ff6666;color:#fff;padding:8px;border:none;border-radius:6px">Excluir</button>
  </form>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
