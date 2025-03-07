<!-- implementos.php -->
<?php include 'includes/header.php';
include 'db/conexao.php'; // Conexão com o banco

// Gera um token CSRF para proteção contra ataques
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<section id="implementos" class="container my-5">
    <h2>Implementos Disponíveis</h2>
    <div class="produtos-container">

        <?php
        $sql = "SELECT i.*, 
        (SELECT imagem FROM implemento_imagens im WHERE im.implemento_id = i.id LIMIT 1) AS imagem_principal 
        FROM implementos i";
        $result = mysqli_query($conn, $sql);    

        while ($row = $result->fetch_assoc()) {
            // Descrição curta
            $descricao_curta = substr($row['descricao'], 0, 140);
        
            // Se houver imagem no banco, usa ela; senão, usa uma imagem padrão
            $imagem = $row['imagem_principal'] ? htmlspecialchars($row['imagem_principal']) : 'images/default.jpg';
        
            echo '<div class="produto">
                <a href="implemento.php?implemento=' . urlencode($row["slug"]) . '">
                    <img src="' . $imagem . '" alt="' . htmlspecialchars($row["nome"]) . '">
                    <h3>' . htmlspecialchars($row["nome"]) . '</h3>
                </a>
                <p>' . htmlspecialchars($descricao_curta) . '...</p>
                <p><strong>R$ ' . number_format($row["preco"], 2, ',', '.') . '</strong></p>
                <a href="implemento.php?implemento=' . urlencode($row["slug"]) . '" class="btn buy">Ver Detalhes</a>
            </div>';
        }
        
        mysqli_close($conn);
        ?>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
 