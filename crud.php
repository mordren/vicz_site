<?php
include 'db/conexao.php';
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Definir a senha correta e o hash dela
$senha_correta = "fadiga123";
$hash_senha = hash('sha256', $senha_correta);

// Inicializar contagem de tentativas e tempo de bloqueio, se ainda não existir
if (!isset($_SESSION['tentativas'])) {
    $_SESSION['tentativas'] = 0;
}
if (!isset($_SESSION['ultimo_erro'])) {
    $_SESSION['ultimo_erro'] = 0;
}

// Se exceder 5 tentativas, bloquear por 10 minutos (600 segundos)
if ($_SESSION['tentativas'] >= 5 && (time() - $_SESSION['ultimo_erro']) < 600) {
    die("⚠️ Acesso bloqueado! Tente novamente em " . (600 - (time() - $_SESSION['ultimo_erro'])) . " segundos.");
}

// Verificar senha enviada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha'])) {
    if (hash('sha256', $_POST['senha']) === $hash_senha) {
        $_SESSION['acesso_crud'] = true;
        $_SESSION['token_acesso'] = $hash_senha;
        $_SESSION['tentativas'] = 0; // Reseta tentativas ao acertar a senha
    } else {
        $_SESSION['tentativas'] += 1;
        $_SESSION['ultimo_erro'] = time();
        echo "<script>alert('Senha incorreta! Tentativas restantes: " . (5 - $_SESSION['tentativas']) . "');</script>";
    }
}

// Se não estiver autenticado, pedir a senha
if (!isset($_SESSION['acesso_crud']) || $_SESSION['token_acesso'] !== $hash_senha) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Proteção do CRUD</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="container mt-5">
        <h2 class="text-center">Digite a senha para acessar o CRUD</h2>
        <form method="POST" class="text-center">
            <input type="password" name="senha" class="form-control w-50 mx-auto mt-3" placeholder="Digite a senha..." required>
            <button type="submit" class="btn btn-primary mt-3">Entrar</button>
        </form>
    </body>
    </html>
    <?php
    exit();
}

// Função para upload seguro de imagens
function uploadImagens($arquivos) {
    $target_dir = "uploads/";
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif']; 
    $imagens_salvas = [];

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    foreach ($arquivos['name'] as $key => $nome) {
        if ($arquivos['error'][$key] === 0) {
            $imageFileType = strtolower(pathinfo($nome, PATHINFO_EXTENSION));

            if (!in_array($imageFileType, $allowed_types)) {
                continue; // Pula arquivos não permitidos
            }

            $novo_nome = uniqid() . "." . $imageFileType;
            $caminho_final = $target_dir . $novo_nome;

            if (move_uploaded_file($arquivos["tmp_name"][$key], $caminho_final)) {
                $imagens_salvas[] = $caminho_final;
            }
        }
    }

    return $imagens_salvas; // Retorna um array com os caminhos das imagens salvas
}


// Função para gerar um slug a partir do nome
function gerarSlug($texto) {
    $slug = strtolower(trim($texto)); // Converter para minúsculas e remover espaços extras
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug); // Remover caracteres especiais
    $slug = preg_replace('/-+/', '-', $slug); // Remover hífens duplicados    
    return trim($slug, '-'); // Remover hífens extras no começo e no fim
}

// CREATE - Inserção de dados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = $_POST['preco'];
    $slug = gerarSlug($nome);

    $sql = "INSERT INTO implementos (nome, descricao, preco, slug) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssds", $nome, $descricao, $preco, $slug);
    
    if (mysqli_stmt_execute($stmt)) {
        $implemento_id = mysqli_insert_id($conn); // Obtém o ID do implemento recém-inserido

        // Upload das imagens e salvar no banco
        $imagens = uploadImagens($_FILES['imagens']);
        foreach ($imagens as $imagem) {
            $sql = "INSERT INTO implemento_imagens (implemento_id, imagem) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "is", $implemento_id, $imagem);
            mysqli_stmt_execute($stmt);
        }

        header("Location: crud.php");
        exit();
    } else {
        echo "Erro ao inserir: " . mysqli_error($conn);
    }
}


// UPDATE - Editar dados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = $_POST['preco'];
    $slug = gerarSlug($nome);

    $sql = "UPDATE implementos SET nome=?, descricao=?, preco=?, slug=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdsi", $nome, $descricao, $preco, $slug, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Se novas imagens foram enviadas, salvar e excluir as antigas
        if (!empty($_FILES['imagens']['name'][0])) {
            // Deletar imagens antigas
            $stmt = mysqli_prepare($conn, "SELECT imagem FROM implemento_imagens WHERE implemento_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($row = mysqli_fetch_assoc($result)) {
                if (file_exists($row['imagem'])) {
                    unlink($row['imagem']); // Remove imagem antiga do servidor
                }
            }

            // Apaga registros antigos no banco
            $stmt = mysqli_prepare($conn, "DELETE FROM implemento_imagens WHERE implemento_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            // Faz upload das novas imagens
            $imagens = uploadImagens($_FILES['imagens']);
            foreach ($imagens as $imagem) {
                $stmt = mysqli_prepare($conn, "INSERT INTO implemento_imagens (implemento_id, imagem) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt, "is", $id, $imagem);
                mysqli_stmt_execute($stmt);
            }
        }

        header("Location: crud.php");
        exit();
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conn);
    }
}



// DELETE - Remover registro
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $stmt = mysqli_prepare($conn, "SELECT imagem FROM implementos WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    if ($data) {
        if (!empty($data['imagem']) && file_exists($data['imagem'])) {
            unlink($data['imagem']); // Remove a imagem
        }

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
            <label>Imagens:</label>
            <input type="file" class="form-control" name="imagens[]" id="imagens" multiple>
            <small class="text-muted">Selecione até 5 imagens.</small>
        </div>
        <button type="submit" class="btn btn-success" name="adicionar" id="btn-submit">Adicionar</button>
        <button type="submit" class="btn btn-primary d-none" name="editar" id="btn-editar">Salvar Alterações</button>
    </form>

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
                <td>
                    <img src="<?= htmlspecialchars($row['imagem']) ?>" width="80">
                </td>
                <td><?= htmlspecialchars($row['nome']) ?></td>
                <td><?= htmlspecialchars($row['descricao']) ?></td>
                <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
                <td>
                    <!-- Botão Editar -->
                    <button class="btn btn-warning btn-sm btn-editar"
                        data-id="<?= $row['id'] ?>"
                        data-nome="<?= htmlspecialchars($row['nome']) ?>"
                        data-descricao="<?= htmlspecialchars($row['descricao']) ?>"
                        data-preco="<?= $row['preco'] ?>"
                        data-imagem="<?= htmlspecialchars($row['imagem']) ?>">
                        Editar
                    </button>

                    <!-- Botão Excluir -->
                    <a href="crud.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm btn-excluir">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Função para carregar os dados no formulário ao clicar em "Editar"
        document.querySelectorAll('.btn-editar').forEach(button => {
            button.addEventListener('click', function () {
                // Pegando os atributos do botão de edição
                let id = this.getAttribute('data-id');
                let nome = this.getAttribute('data-nome');
                let descricao = this.getAttribute('data-descricao');
                let preco = this.getAttribute('data-preco');
                let imagem = this.getAttribute('data-imagem');

                // Preenchendo os campos do formulário
                document.getElementById('id').value = id;
                document.getElementById('nome').value = nome;
                document.getElementById('descricao').value = descricao;
                document.getElementById('preco').value = preco;

                let preview = document.getElementById('preview');
                if (imagem) {
                    preview.src = imagem;
                    preview.classList.remove('d-none');
                } else {
                    preview.classList.add('d-none');
                }

                // Mostrar o botão "Salvar Alterações" e esconder "Adicionar"
                document.getElementById('btn-submit').classList.add('d-none');
                document.getElementById('btn-editar').classList.remove('d-none');
            });
        });

        // Resetar o formulário ao recarregar a página
        document.getElementById('btn-submit').addEventListener('click', function () {
            document.getElementById('id').value = "";
            document.getElementById('btn-submit').classList.remove('d-none');
            document.getElementById('btn-editar').classList.add('d-none');
        });

        // Confirmação ao excluir um implemento
        document.querySelectorAll('.btn-excluir').forEach(button => {
            button.addEventListener('click', function (event) {
                let confirmacao = confirm("Tem certeza que deseja excluir este implemento?");
                if (!confirmacao) {
                    event.preventDefault(); // Cancela a exclusão
                }
            });
        });
    });
</script>


</html>
