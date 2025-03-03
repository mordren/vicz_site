<?php
session_start();
include 'db/conexao.php'; // Conexão com o banco

// Gera um token CSRF para proteção contra ataques
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Função para fazer upload de imagens com segurança
function uploadImagem($arquivo) {
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif']; // Tipos permitidos

    if ($arquivo['error'] == 4) {
        return null; // Nenhum arquivo enviado
    }

    $target_dir = "uploads/";

    // Criar a pasta se não existir
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $imageFileType = strtolower(pathinfo($arquivo["name"], PATHINFO_EXTENSION));

    if (!in_array($imageFileType, $allowed_types)) {
        die("Erro: Tipo de arquivo não permitido.");
    }

    $novo_nome = uniqid() . "." . $imageFileType;
    $caminho_final = $target_dir . $novo_nome;

    if (move_uploaded_file($arquivo["tmp_name"], $caminho_final)) {
        return $caminho_final;
    } else {
        return null;
    }
}

// CREATE - Inserção de dados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erro de segurança: Requisição inválida.");
    }

    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = $_POST['preco'];
    $imagem = uploadImagem($_FILES['imagem']) ?? '';

    $sql = "INSERT INTO implementos (nome, descricao, imagem, preco) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssd", $nome, $descricao, $imagem, $preco);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: crud.php");
        exit();
    } else {
        echo "Erro ao inserir: " . mysqli_error($conn);
    }
}

// DELETE - Remover registro e imagem associada
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Buscar imagem antes de excluir
    $stmt = mysqli_prepare($conn, "SELECT imagem FROM implementos WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    if ($data) {
        // Se houver imagem, remove do servidor
        if (!empty($data['imagem']) && file_exists($data['imagem'])) {
            unlink($data['imagem']);
        }

        // Excluir do banco
        $stmt = mysqli_prepare($conn, "DELETE FROM implementos WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: crud.php");
            exit();
        } else {
            echo "Erro ao excluir: " . mysqli_error($conn);
        }
    } else {
        echo "Registro não encontrado!";
    }
}

// UPDATE - Editar dados e atualizar imagem se necessário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erro de segurança: Requisição inválida.");
    }

    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = $_POST['preco'];

    // Buscar a imagem atual
    $stmt = mysqli_prepare($conn, "SELECT imagem FROM implementos WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    $imagem_atual = $data['imagem'];

    // Se uma nova imagem foi enviada, faz o upload e substitui a antiga
    $nova_imagem = uploadImagem($_FILES['imagem']);
    if ($nova_imagem) {
        if (!empty($imagem_atual) && file_exists($imagem_atual)) {
            unlink($imagem_atual); // Remove imagem antiga
        }
    } else {
        $nova_imagem = $imagem_atual; // Mantém a imagem antiga se nenhuma nova for enviada
    }

    // Atualizar no banco
    $stmt = mysqli_prepare($conn, "UPDATE implementos SET nome=?, descricao=?, imagem=?, preco=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssdi", $nome, $descricao, $nova_imagem, $preco, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: crud.php");
        exit();
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conn);
    }
}

// READ - Buscar todos os registros
$result = mysqli_query($conn, "SELECT * FROM implementos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Seguro - Implementos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="text-center">Gerenciamento de Implementos</h2>

    <!-- Formulário para Adicionar ou Editar -->
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" class="form-control" name="nome" id="nome" required>
        </div>
        <div class="mb-3">
            <label>Descrição:</label>
            <textarea class="form-control" name="descricao" id="descricao"></textarea>
        </div>
        <div class="mb-3">
            <label>Preço:</label>
            <input type="number" class="form-control" name="preco" id="preco" step="0.01" required>
        </div>
        <div class="mb-3">
            <label>Imagem:</label>
            <input type="file" class="form-control" name="imagem" id="imagem">
        </div>
        <button type="submit" class="btn btn-success" name="adicionar" id="btn-submit">Adicionar</button>
    </form>

    <!-- Lista os Registros -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($row['imagem']) ?>" width="80"></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['descricao']) ?></td>
                    <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
                    <td>
                        <a href="crud.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
