<?php
// run_migration.php

// Inclui os arquivos necessários
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/CreateTables.php';

echo "<pre>";
echo "Iniciando a criação da tabela 'monthly_fees'...
";

// Verifica se a conexão com o banco de dados ($conn) está disponível
if (isset($conn)) {
    // Chama a função específica para criar a tabela de mensalidades
    CreateTables::createMonthlyFeesTable($conn);
    echo "Script de criação da tabela 'monthly_fees' executado.
";
    echo "Por favor, verifique seu banco de dados para confirmar que a tabela foi criada.
";

    // Fecha a conexão
    $conn->close();
} else {
    echo "Erro: Não foi possível estabelecer a conexão com o banco de dados. Verifique o arquivo config/db.php.
";
}

echo "Você pode apagar este arquivo (run_migration.php) agora.
";
echo "</pre>";
?>
