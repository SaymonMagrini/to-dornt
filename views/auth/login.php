<?php $this->layout('layouts/auth', ['title' => 'Login']) ?>

<h2 style="text-align:center;">Acesse sua conta</h2>

<form method="POST" action="/login">
    <input type="email" name="email" class="input-texto" placeholder="E-mail" required>
    <input type="password" name="password" class="input-texto" placeholder="Senha" required>
    <button type="submit" class="btn">Entrar</button>
</form>

<p style="text-align:center;">
    Não tem conta? <a href="/register">Registrar</a>
</p>
