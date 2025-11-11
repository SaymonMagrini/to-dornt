<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Registrar</title>
  <style>
    body {
      background-color: #0C0C0C;
      color: #FFFFFF;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #303030;
      display: flex;
      justify-content: left;
      align-items: center;
      padding: 10px;
    }

    .header__itm {
      color: #FFFFFF;
      background-color: #303030;
      font-weight: 700;
      text-decoration: none;
      padding: 10px 15px;
      border: 2px solid #00ffff;
      margin: 5px;
      border-radius: 8px;
    }

    .header__itm:hover {
      background-color: #00ffff;
      color: #000;
    }

    .container {
      padding: 20px;
      max-width: 400px;
      margin: 40px auto;
      background-color: #1a1a1a;
      border-radius: 10px;
      box-shadow: 0 0 10px #00ffff33;
    }

    .titulo {
      text-align: center;
      margin-bottom: 15px;
    }

    .input-texto {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 2px solid #00ffff;
      border-radius: 6px;
      background-color: #0C0C0C;
      color: #FFFFFF;
    }

    .btn {
      width: 100%;
      padding: 10px;
      background-color: #00ffff;
      border: none;
      border-radius: 6px;
      color: #000;
      font-weight: bold;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #00cccc;
    }

    a {
      color: #00ffff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    p {
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="header">
    <a href="/login.php" class="header__itm">Login</a>
    <a href="/register.php" class="header__itm">Registrar</a>
  </div>

  <div class="container">
    <h2 class="titulo">Crie sua conta</h2>
    <p class="subtitulo" style="text-align:center;">Preencha os dados abaixo para se cadastrar.</p>

    <?php foreach (\App\Core\Flash::getAll() as $msg): ?>
      <p style="color: red;"><?= htmlspecialchars($msg['message']) ?></p>
    <?php endforeach; ?>

    <form method="POST" action="/register.php">
      <input type="text" name="name" placeholder="Nome completo" required class="input-texto">
      <input type="email" name="email" placeholder="E-mail" required class="input-texto">
      <input type="password" name="password" placeholder="Senha" required class="input-texto">
      <button type="submit" class="btn">Cadastrar</button>
    </form>

    <p>Já tem uma conta? <a href="/login.php">Faça login</a></p>
  </div>
</body>
</html>
