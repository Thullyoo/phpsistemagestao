<?php
    require_once '../banco/db.php';
    $db = new Database();
    $conn = $db->getConnection();
    $evento = null;
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id && $action !== 'delete') {
        $stmt = $conn->prepare("SELECT * FROM eventos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $evento = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $data_evento = $_POST['data_evento'];
        $vagas = (int)$_POST['vagas'];
        $carga_horaria = (int)$_POST['carga_horaria'];

        if ($id) {
            $stmt = $conn->prepare("UPDATE eventos SET nome = ?, descricao = ?, data_evento = ?, vagas = ?, carga_horaria = ? WHERE id = ?");
            $stmt->bind_param("sssiii", $nome, $descricao, $data_evento, $vagas, $carga_horaria, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO eventos (nome, descricao, data_evento, vagas, carga_horaria) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssii", $nome, $descricao, $data_evento, $vagas, $carga_horaria);
        }

        if ($stmt->execute()) {
            header("Location: evento_list.php");
            exit;
        } else {
            $error = "Erro: " . $conn->error;
        }
        $stmt->close();
    } elseif ($action === 'delete' && $id) {
        $stmt = $conn->prepare("DELETE FROM eventos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: evento_list.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Editar' : 'Novo'; ?> Evento</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; }
        input, textarea { width: 100%; padding: 8px; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2><?php echo $id ? 'Editar' : 'Novo'; ?>‌آEvento</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" value="<?php echo isset($evento['nome']) ? htmlspecialchars($evento['nome']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Descrição</label>
            <textarea name="descricao"><?php echo isset($evento['descricao']) ? htmlspecialchars($evento['descricao']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label>Data do Evento</label>
            <input type="datetime-local" name="data_evento" value="<?php echo isset($evento['data_evento']) ? htmlspecialchars($evento['data_evento']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Vagas</label>
            <input type="number" name="vagas" value="<?php echo isset($evento['vagas']) ? htmlspecialchars($evento['vagas']) : ''; ?>" min="0" required>
        </div>
        <div class="form-group">
            <label>Carga Horária</label>
            <input type="number" name="carga_horaria" value="<?php echo isset($evento['carga_horaria']) ? htmlspecialchars($evento['carga_horaria']) : ''; ?>" required>
        </div>
        <button type="submit">Salvar</button>
        <a href="evento_list.php">Cancelar</a>
    </form>
</body>
</html>