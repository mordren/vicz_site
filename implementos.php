<!-- implementos.php -->
<?php include 'includes/header.php'; ?>
<?php include 'db/conexao.php'; ?>

<section id="implementos" class="container my-5">
    <h2>Implementos Disponíveis</h2>
    <div class="produtos-container">

        <?php
        $sql = "SELECT * FROM implementos";
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

<?php include 'includes/footer.php'; ?>
