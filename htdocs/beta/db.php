<?php
// db mockada para demonstração
$tasks = [
    [
        'id' => 1,
        'title' => 'Revisar relatório financeiro',
        'description' => 'Verificar os dados do relatório financeiro mensal e corrigir inconsistências.',
        'status' => 'pending', // pending, in_progress, completed
        'due_date' => '2025-11-05'
    ],
    [
        'id' => 2,
        'title' => 'Atualizar site institucional',
        'description' => 'Adicionar novos produtos e atualizar as imagens da página inicial.',
        'status' => 'in_progress',
        'due_date' => '2025-11-07'
    ],
    [
        'id' => 3,
        'title' => 'Agendar reunião com equipe de marketing',
        'description' => 'Discutir a nova campanha de mídia social e definir cronograma.',
        'status' => 'pending',
        'due_date' => '2025-11-04'
    ],
    [
        'id' => 4,
        'title' => 'Testar integração com API externa',
        'description' => 'Verificar se os endpoints da API estão retornando os dados corretamente.',
        'status' => 'completed',
        'due_date' => '2025-10-30'
    ],
    [
        'id' => 5,
        'title' => 'Backup do banco de dados',
        'description' => 'Realizar backup completo do banco de dados e salvar na nuvem.',
        'status' => 'pending',
        'due_date' => '2025-11-01'
    ]
];

?>
