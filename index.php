<!-- index.php -->
<?php include 'includes/header.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php include 'db/conexao.php'; ?>

<!-- Conteúdo Principal -->
<main>
    <div class="banner">
        <video autoplay loop muted playsinline>
            <source src="./images/asda.mp4" type="video/mp4">
            <source src="background.webm" type="video/webm">
            Seu navegador não suporta vídeos em HTML5.
        </video>
        <div class="banner-overlay">
            <h1 class="display-4">Bem-vindo à Vicz Implementos/Rodosul</h1>
            <p class="lead">Excelência, Inovação e Segurança no Transporte de Produtos Perigosos.</p>
        </div>
    </div>
    <section class="container my-5 about">
        <h2 class="text-center text-primary">Visão Geral da Empresa</h2>
        <p class="text-center">
        A Vicz Implementos/Rodosul foi criada para ser referência no Estado do Tocantins. Seus fundadores são oriundos de Cascavel, Paraná, onde atuaram por mais de 15 anos, na gestão de fábricas de implementos rodoviários, consultoria em área de inspeção de produtos perigosos e consultoria jurídica na área de produtos perigosos. Inicialmente, vieram para o Tocantins para atividades agrícolas, e após seis meses no Estado, perceberam a carência de serviços na área de produtos perigosos, fundando assim a empresa para suprir essa lacuna.A Vicz Implementos/Rodosul foi criada para ser referência no Estado do Tocantins. Seus fundadores são oriundos de Cascavel, Paraná, onde atuaram por mais de 15 anos, na gestão de fábricas de implementos rodoviários, consultoria em área de inspeção de produtos perigosos e consultoria jurídica na área de produtos perigosos. Inicialmente, vieram para o Tocantins para atividades agrícolas, e após seis meses no Estado, perceberam a carência de serviços na área de produtos perigosos, fundando assim a empresa para suprir essa lacuna.
        </p>
        asdgysagydgsaygdygsaygdyasygdasdphais
    </section>
    <section id="implementos-home" class="container my-5">
    <h2  class="text-center text-primary">Confira Nossos Implementos</h2>
    <div class="produtos-container">

        <?php
        $sql = "SELECT * FROM implementos ORDER BY RAND() LIMIT 3";
        $result = mysqli_query($conn, $sql);    

        while ($row = $result->fetch_assoc()) {
            echo '<div class="produto">
                    <img src="' . $row["imagem"] . '" alt="' . $row["nome"] . '">
                    <h3>' . $row["nome"] . '</h3>
                    <p>' . $row["descricao"] . '</p>
                    <p><strong>R$ ' . number_format($row["preco"], 2, ',', '.') . '</strong></p>
                    <a href="implemento.php?id=' . $row["id"] . '" class="btn btn-primary">Ver Detalhes</a>
                </div>';
        }
        mysqli_close($conn);
        ?>

    </div>   
</section>
</main>
<?php include 'includes/footer.php'; ?>
