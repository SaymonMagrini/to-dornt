<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="/beta/assets/style.css">
</head>
<body>

  <div class="header">
    <span class="header__itm">Login</span>
  </div>

  <div class="login-container">
    <?php
    use App\Core\Flash;
    foreach (Flash::getAll() as $msg): ?>
      <p style="color:<?= $msg['type']==='danger'?'red':'#00ffff' ?>;">
        <?= htmlspecialchars($msg['message']) ?>
      </p>
    <?php endforeach; ?>

    <form method="POST" action="/auth/login">
      <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf ?? '') ?>">

      <input type="email" name="email" placeholder="E-mail" required class="input-texto">
      <input type="password" name="password" placeholder="Senha" required class="input-texto">

      <button type="submit" class="btn">Entrar</button>
    </form>
  </div>
</body>
</html>
