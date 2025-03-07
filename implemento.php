<?php
include 'db/conexao.php';

// Verifica se o slug foi passado corretamente na URL
if (!isset($_GET["implemento"]) || empty($_GET["implemento"])) {
    die("Erro: Implemento não encontrado.");
}

$slug = $_GET["implemento"];

// Prepara a query SQL para buscar pelo slug
$sql = "SELECT * FROM implementos WHERE slug = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$sql = "SELECT imagem FROM implemento_imagens WHERE implemento_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $row['id']);
mysqli_stmt_execute($stmt);
$imagens_result = mysqli_stmt_get_result($stmt);


$sql = "SELECT * FROM implementos WHERE slug = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verifica se o implemento existe
if ($result->num_rows == 0) {
    die("Erro: Implemento não encontrado.");
}

$row = mysqli_fetch_assoc($result);

// Garante que a descrição não seja NULL
$descricao = $row['descricao'] ?? 'Descrição não disponível';

// Agora que tudo foi validado, podemos incluir o header
?>
<head>
<?php
// Criar JSON-LD dinâmico baseado no implemento
$schemaData = [
    "@context" => "https://schema.org/",
    "@type" => "Product",
    "name" => htmlspecialchars($row['nome']),
    "image" => "https://viczimplementos.com.br/" . htmlspecialchars($row['imagem']),
    "description" => htmlspecialchars($row['descricao']),
    "brand" => [
        "@type" => "Brand",
        "name" => "Vicz Implementos"
    ],
    "offers" => [
        "@type" => "Offer",
        "url" => "https://viczimplementos.com.br/implemento.php?implemento=" . urlencode($row['slug']),
        "priceCurrency" => "BRL",
        "price" => number_format($row['preco'], 2, '.', ''),
        "availability" => "https://schema.org/InStock",
        "seller" => [
            "@type" => "Organization",
            "name" => "Vicz Implementos"
        ]
    ]
];
?>
<script type="application/ld+json">
<?= json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
</script>
</head>
<?php
include 'includes/header.php';
?>

<section class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <div id="carouselImagens" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $first = true; while ($imagem = mysqli_fetch_assoc($imagens_result)) { ?>
                        <div class="carousel-item <?= $first ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars($imagem['imagem']) ?>" class="d-block w-100">
                        </div>
                    <?php $first = false; } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselImagens" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselImagens" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($row['nome']); ?></h1>
            <p><?php echo htmlspecialchars($descricao); ?></p>
            <h4 class="">Preço à partir: <span class="preco">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></span></h4>

            <?php 
                // Nome do implemento para a mensagem do WhatsApp
                $mensagem = "Olá!%20Tenho%20interesse%20no%20implemento%20" . urlencode($row['nome']) . ".%20Pode%20me%20passar%20mais%20informações?";
                $whatsapp_link = "https://wa.me/556341413535?text=" . $mensagem;
            ?>

            <div class="d-flex gap-3 mt-4">
                <a href="implementos.php" class="btn btn-secondary">Voltar</a>
                <a href="<?= $whatsapp_link ?>" class="btn btn-success" target="_blank">
                    <i class="fa fa-whatsapp"></i> Solicite Orçamento
                </a>
            </div>
        </div>
    </div>
</section>

<?php mysqli_close($conn); ?>
<?php include 'includes/footer.php'; ?>
