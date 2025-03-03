<?php
include 'db/conexao.php';
include 'includes/header.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT * FROM implementos WHERE nome LIKE '%$q%' OR descricao LIKE '%$q%'";
$result = mysqli_query($conn, $sql);
?>

<main class="container">
    <h2 class="text-center">Resultados da Busca</h2>
    <div class="produtos-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="produto">
                        <img src="' . $row["imagem"] . '" alt="' . $row["nome"] . '">
                        <h3>' . $row["nome"] . '</h3>
                        <p>' . $row["descricao"] . '</p>
                        <p><strong>R$ ' . number_format($row["preco"], 2, ',', '.') . '</strong></p>
                        <a href="implemento.php?id=' . $row["id"] . '" class="btn buy">Ver Detalhes</a>
                    </div>';
            }
        } else {
            echo "<p class='text-center'>Nenhum implemento encontrado.</p>";
        }
        mysqli_close($conn);
        ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
