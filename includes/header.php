<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<?php

//verifica se a sessão está ativa 
if (session_status() === PHP_SESSION_NONE) {    
    session_start();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Pega a página atual
$pagina_atual = basename($_SERVER['PHP_SELF']); 

// Define títulos e descrições dinâmicas
switch ($pagina_atual) {
    case 'index.php':
        $titulo_pagina = "Vicz Implementos - Implementos Rodoviários de Qualidade";
        $descricao_pagina = "A Vicz Implementos oferece soluções seguras e eficientes para transporte de produtos perigosos.";
        break;

    case 'implementos.php':
        $titulo_pagina = "Implementos Disponíveis - Vicz Implementos";
        $descricao_pagina = "Confira nossa linha de implementos rodoviários para transporte seguro e eficiente.";
        break;

    case 'sobre.php':
        $titulo_pagina = "Sobre Nós - Vicz Implementos";
        $descricao_pagina = "Saiba mais sobre a Vicz Implementos, nossa história e compromisso com a qualidade.";
        break;

    case 'contato.php':
        $titulo_pagina = "Fale Conosco - Vicz Implementos";
        $descricao_pagina = "Entre em contato com a Vicz Implementos e solicite um orçamento personalizado.";
        break;

    case 'implemento.php':
        $titulo_pagina = isset($row['nome']) ? htmlspecialchars($row['nome']) . " - Vicz Implementos" : "Implemento não encontrado";
        $descricao_pagina = isset($row['descricao']) ? htmlspecialchars(substr($row['descricao'], 0, 150)) : "Detalhes sobre este implemento.";
        break;

    default:
        $titulo_pagina = "Vicz Implementos - Implementos Rodoviários";
        $descricao_pagina = "Soluções de qualidade para transporte de cargas e produtos perigosos.";
        break;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $titulo_pagina; ?></title>
    <meta name="description" content="<?php echo $descricao_pagina . ' Localizada em Luzimangues, Porto Nacional - Tocantins, ao lado de Palmas.'; ?>">
    
    <!-- Meta tags para SEO -->
    <meta name="keywords" content="implementos, transporte, carga, caminhão, reboque, semi-reboque, Tocantins, Luzimangues, Porto Nacional, Palmas">
    <meta name="author" content="qualidade@cerezoliqualidade.com.br">
    <meta name="robots" content="index, follow">
    
    <!-- Meta para Localização (Ajuda no SEO Local) -->
    <meta name="geo.region" content="BR-TO"> <!-- Estado de Tocantins -->
    <meta name="geo.placename" content="Luzimangues, Porto Nacional, Tocantins">
    <meta name="geo.position" content="-10.2703,-48.3287"> <!-- Latitude e Longitude de Luzimangues -->
    <meta name="ICBM" content="-10.2703,-48.3287"> <!-- Informação Geográfica para Mecanismos de Busca -->

    <!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:title" content="<?php echo $titulo_pagina; ?>">
    <meta property="og:description" content="<?php echo $descricao_pagina . ' Localizada em Luzimangues, Porto Nacional - Tocantins, ao lado de Palmas.'; ?>">
    <meta property="og:image" content="https://viczimplementos.com.br/images/logo.png">
    <meta property="og:url" content="https://viczimplementos.com.br/<?php echo $pagina_atual; ?>">
    <meta property="og:type" content="business.business">
    <meta property="business:contact_data:street_address" content="Luzimangues">
    <meta property="business:contact_data:locality" content="Porto Nacional">
    <meta property="business:contact_data:region" content="Tocantins">
    <meta property="business:contact_data:country_name" content="Brasil">

    <!-- Twitter Cards -->
    <meta name="twitter:title" content="<?php echo $titulo_pagina; ?>">
    <meta name="twitter:description" content="<?php echo $descricao_pagina . ' Localizada em Luzimangues, Porto Nacional - Tocantins, ao lado de Palmas.'; ?>">
    <meta name="twitter:image" content="https://viczimplementos.com.br/images/logo.png">
    <meta name="twitter:card" content="summary_large_image">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : "Vicz Implementos - Implementos Rodoviários"; ?></title>
    
    <meta name="description" content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : "A Vicz Implementos é referência na fabricação de implementos rodoviários. Conheça nossos produtos e solicite um orçamento."; ?>">

    <meta name="keywords" content="implementos rodoviários, transporte, tanque inox, carreta agrícola, caminhão tanque, vicz implementos">
    <meta name="author" content="contato@cerezoliqualidade.com.br">



    <!-- Ícone do site -->

    <!-- CSS Principal -->
    <link rel="stylesheet" href="./css/style.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Vicz Implementos",
        "url": "https://viczimplementos.com.br/",
        "logo": "https://viczimplementos.com.br/images/logo.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+55-63-4141-3535",
            "contactType": "customer service",
            "areaServed": "BR",
            "availableLanguage": "Portuguese"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Distrito de Luzimangues, TO-080",
            "addressLocality": "Porto Nacional",
            "addressRegion": "TO",
            "postalCode": "77500-000",
            "addressCountry": "BR"
        }
    }
</script>
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
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input class="form-control me-2" type="search" name="q" placeholder="Buscar implemento..." required>
                    <button class="btn btn-outline-light" type="submit">Buscar</button>
                </form>
            </li>
            </ul>

        </div>
    </div>
</nav>
