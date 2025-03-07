<?php

include __DIR__ . '/../config/config.php';

if (basename($_SERVER['PHP_SELF']) == "conexao.php") {
    die("Acesso negado!");
}


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Erro na conexão");
}


?>