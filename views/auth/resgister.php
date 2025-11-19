<?php $this->layout('layouts/auth', ['title' => 'Registrar']) ?>

<h2 style="text-align:center;">Criar conta</h2>

<form method="POST" action="/register">
    <input type="text" name="name" class="input-texto" placeholder="Seu nome" required>
    <input type="email" name="email" class="input-texto" placeholder="E-mail" required>
    <input type="password" name="password" class="input-texto" placeholder="Senha" required>
    <button type="submit" class="btn">Registrar</button>
</form>

<p style="text-align:center;">
    Já tem conta? <a href="/login">Entrar</a>
</p>
