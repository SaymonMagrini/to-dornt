<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

  <div class="header">
    <a href="/login.php" class="header__itm">Login</a>
    <a href="/register.php" class="header__itm">Registrar</a>
  </div>

  <div class="container">
    <h2 class="titulo">Acesse sua conta</h2>
    <p class="subtitulo" style="text-align:center;">Digite seu e-mail e senha para continuar.</p>

    <?php \App\Core\Flash::render(); ?>

    <form method="POST" action="/login.php">
      <input type="email" name="email" placeholder="E-mail" required class="input-texto">
      <input type="password" name="password" placeholder="Senha" required class="input-texto">
      <button type="submit" class="btn">Entrar</button>
    </form>

    <p>Não tem conta? <a href="/register.php">Registre-se aqui</a></p>
  </div>
</body>

</html>