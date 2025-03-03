<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vicz Implementos/Rodosul</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Barra de navegação -->
<nav class="navbar navbar-expand-lg navbar-dark w-100" style="background-color: #1c294b;">
    <div class="container-fluid">

        <!-- Logo centralizada no mobile -->
        <a class="navbar-brand mx-lg-0 mx-auto" href="index.php">
            <img src="./images/logo.png" width="120" height="80" class="d-inline-block align-center" alt="Logo">
        </a>

        <!-- Ícone do menu alinhado à direita -->
        <button class="navbar-toggler border-white custom-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item"><a class="nav-link text-white" href="./">Início</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="implementos.php">Implementos</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="sobre.php">Sobre Nós</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="contato.php">Contato</a></li>
            
            <li>            
                <form action="busca.php" method="GET" class="d-flex ms-lg-3 mt-2 mt-lg-0">
                    <input class="form-control me-2" type="search" name="q" placeholder="Buscar implemento..." required>
                    <button class="btn btn-outline-light" type="submit">Buscar</button>
                </form>
            </li>
            </ul>

        </div>
    </div>
</nav>

