<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Login</h2>
  <?php if (!empty($error)): ?><p style="color:#ff6666"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  <form method="POST" action="/?p=auth/login">
    <input class="input" type="email" name="email" placeholder="Email" required>
    <input class="input" type="password" name="password" placeholder="Senha" required>
    <button class="btn">Entrar</button>
  </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
