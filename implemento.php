<!-- implemento.php -->
<?php include 'includes/header.php'; ?>
<?php include 'db/conexao.php'; ?>

<?php
if (!isset($_GET["id"])) {
    die("Implemento não encontrado.");
}

$id = intval($_GET["id"]);
$sql = "SELECT * FROM implementos WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result->num_rows == 0) {
    die("Implemento não encontrado.");
}

$row = $result->fetch_assoc();
?>

<section class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $row['imagem']; ?>" class="img-fluid" alt="<?php echo $row['nome']; ?>">
        </div>
        <div class="col-md-6">
            <h2><?php echo $row['nome']; ?></h2>
            <p><?php echo $row['descricao']; ?></p>
            <h4 class="text-primary">Preço: R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></h4>

            <!-- Botões "Voltar" e "WhatsApp" -->
            <div class="d-flex gap-3 mt-4">
                <a href="implementos.php" class="btn btn-secondary">
                    Voltar
                </a>
                <a href="https://wa.me/5545999617454" class="btn btn-success" target="_blank">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<?php mysqli_close($conn); ?>

<?php include 'includes/footer.php'; ?>
