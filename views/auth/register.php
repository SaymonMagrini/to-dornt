<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <link rel="stylesheet" href="/beta/assets/style.css">
</head>
<body>

  <div class="header">
    <a href="/login" class="header__itm">Login</a>
    <a href="/register" class="header__itm">Registrar</a>
  </div>

  <div class="container">
    <h2 class="titulo">Criar Conta</h2>

    <?php foreach (\App\Core\Flash::getAll() as $msg): ?>
      <p style="color: red;"><?= htmlspecialchars($msg['message']) ?></p>
    <?php endforeach; ?>

    <form method="POST" action="/register.php" class="form-tarefa">
      <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">

      <input type="text" name="name" placeholder="Nome" required class="input-texto">
      <input type="email" name="email" placeholder="E-mail" required class="input-texto">
      <input type="password" name="password" placeholder="Senha" required class="input-texto">

      <button type="submit" class="btn">Cadastrar</button>
    </form>

    <p>Já tem conta? <a href="/login.php" style="color:#00ffff;">Fazer login</a></p>
  </div>
</body>
</html>
