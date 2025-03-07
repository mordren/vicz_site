<!-- index.php -->
<?php include 'includes/header.php';
include 'db/conexao.php'; // Conexão com o banco
?>
<!-- Conteúdo Principal -->
<main>
    <div class="banner">
        <video autoplay loop muted playsinline>
            <source src="./images/asda.mp4" type="video/mp4">
            <source src="background.webm" type="video/webm">
            Seu navegador não suporta vídeos em HTML5.
        </video>
        <div class="banner-overlay">
            <h1 class="display-4" style="color: #FFF !important">Bem-vindo à Vicz Implementos</h1>
            <p class="lead">Excelência, Inovação e Segurança no Transporte de Produtos Perigosos.</p>
            <p><a href="https://wa.me/556341413535" class="btn btn-success btn-whats" target="_blank">
                    <i class="fa fa-whatsapp"></i> Orçamento Personalizado
                </a></p>
        </div>
    </div>
    <section class="container about">
        <h2 class="text-center">Visão Geral da Empresa</h2>
        <p class="text-center">
        A Vicz Implementos foi criada para ser referência no Estado do Tocantins. Seus fundadores são oriundos de Cascavel, Paraná, onde atuaram por mais de 15 anos, na gestão de fábricas de implementos rodoviários, consultoria em área de inspeção de produtos perigosos e consultoria jurídica na área de produtos perigosos. Inicialmente, vieram para o Tocantins para atividades agrícolas, e após seis meses no Estado, perceberam a carência de serviços na área de produtos perigosos, fundando assim a empresa para suprir essa lacuna. 
        </p>        
        <p></p>
    </section>
    <section id="implementos-home" class="container">
        <h2  class="text-center">Confira Nossos Implementos</h2>
        <div class="produtos-container">
            <?php
           $sql = "SELECT i.*, 
           (SELECT imagem FROM implemento_imagens im WHERE im.implemento_id = i.id LIMIT 1) AS imagem_principal 
           FROM implementos i 
           ORDER BY RAND() 
           LIMIT 3";
   
            $result = mysqli_query($conn, $sql);  
            while ($row = $result->fetch_assoc()) {
                $descricao_curta = substr($row['descricao'], 0, 140);
                $imagem = $row['imagem_principal'] ? htmlspecialchars($row['imagem_principal']) : 'images/default.jpg';
                echo '<div class="produto">
                        <img src="' . $imagem . '" alt="' . $row["nome"] . '">
                        <h3>' . $row["nome"] . '</h3>
                        <p>' . $descricao_curta . '...</p>
                        <p><strong>R$ ' . number_format($row["preco"], 2, ',', '.') . '</strong></p>
                        <a href="implemento.php?implemento=' . urlencode($row["slug"]) . '" class="btn buy">Ver Detalhes</a>                        
                    </div>';
            }
            mysqli_close($conn);
            ?>
        </div>
    </section>
</main>


<?php include 'includes/footer.php'; ?>
