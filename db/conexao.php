<?php

$config_path = __DIR__ . '/../../config/config.php';


if (basename($_SERVER['PHP_SELF']) == "conexao.php") {
    die("Acesso negado!");
}

if (!file_exists($config_path)) {
    die("Erro: Arquivo config.php não encontrado! Caminho: " . $config_path);
}

include $config_path;


// Conectar ao banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

?>