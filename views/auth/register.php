<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Registrar</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

  <div class="header">
    <a href="/login.php" class="header__itm">Login</a>
    <a href="/register.php" class="header__itm">Registrar</a>
  </div>

  <div class="container">
    <h2 class="titulo">Crie sua conta</h2>
    <p class="subtitulo" style="text-align:center;">Preencha os dados abaixo para se cadastrar.</p>


    <?php \App\Core\Flash::render(); ?>

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