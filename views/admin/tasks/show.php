<?php $this->layout('layouts/base', ['title' => 'Detalhes da Tag']) ?>

<h2>Detalhes da Tag</h2>

<div class="detalhes">
    <p><strong>ID:</strong> <?= htmlspecialchars($tag['id']) ?></p>
    <p><strong>Nome:</strong> <?= htmlspecialchars($tag['name']) ?></p>
</div>

<a class="btn" href="javascript:history.back()">Voltar</a>