<?php
    require_once '../banco/db.php';
    $db = new Database();
    $conn = $db->getConnection();
    $participante = null;
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id && $action !== 'delete') {
        $stmt = $conn->prepare("SELECT * FROM participantes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $participante = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $matricula = $_POST['matricula'];
        $curso = $_POST['curso'];

        try {
            if ($id) {
                $stmt = $conn->prepare("UPDATE participantes SET nome = ?, email = ?, matricula = ?, curso = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $nome, $email, $matricula, $curso, $id);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("INSERT INTO participantes (nome, email, matricula, curso, data_inscricao) VALUES (?, ?, ?, ?, NOW())");
                $stmt->bind_param("ssss", $nome, $email, $matricula, $curso);
                $stmt->execute();
            }
            header("Location: participante_list.php");
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $error = "Erro: O email '$email' já está cadastrado. Por favor, use outro email.";
            } else {
                $error = "Erro ao salvar: " . $e->getMessage();
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    } elseif ($action === 'delete' && $id) {
        $stmt = $conn->prepare("DELETE FROM participantes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: participante_list.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Editar' : 'Novo'; ?> Participante</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; }
        input, select { width: 100%; padding: 8px; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2><?php echo $id ? 'Editar' : 'Novo'; ?> Participante</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" value="<?php echo isset($participante['nome']) ? htmlspecialchars($participante['nome']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo isset($participante['email']) ? htmlspecialchars($participante['email']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Matrícula</label>
            <input type="text" name="matricula" value="<?php echo isset($participante['matricula']) ? htmlspecialchars($participante['matricula']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Curso</label>
            <input type="text" name="curso" value="<?php echo isset($participante['curso']) ? htmlspecialchars($participante['curso']) : ''; ?>" required>
        </div>
        <button type="submit">Salvar</button>
        <a href="participante_list.php">Cancelar</a>
    </form>
</body>
</html>