<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
</head>
<body>
  <h2>Criar Conta</h2>

  <?php foreach (\App\Core\Flash::getAll() as $msg): ?>
    <p style="color: red;"><?= htmlspecialchars($msg['message']) ?></p>
  <?php endforeach; ?>

  <form method="POST" action="/register.php">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">

    <label>Nome:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Senha:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Cadastrar</button>
  </form>

  <p>Já tem conta? <a href="/login.php">Fazer login</a></p>
</body>
</html>
