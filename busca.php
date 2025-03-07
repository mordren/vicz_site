<?php
include 'db/conexao.php';
include 'includes/header.php';
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$stmt = mysqli_prepare($conn, "SELECT * FROM implementos WHERE nome LIKE ?");
$busca = "%".$_GET['q']."%";
mysqli_stmt_bind_param($stmt, "s", $busca);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<main class="container">
    <h2 class="text-center">Resultados da Busca</h2>
    <div class="produtos-container">
        <?php
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Erro de segurança: Requisição inválida.");
        }

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


