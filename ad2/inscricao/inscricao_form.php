<?php
    require_once '../banco/db.php';
    $db = new Database();
    $conn = $db->getConnection();
    $result = $conn->query("SELECT id, nome FROM participantes");
    $participantes = $result->fetch_all(MYSQLI_ASSOC);
    $result = $conn->query("SELECT id, nome, data_evento, vagas FROM eventos WHERE data_evento > NOW() AND vagas > 0");
    $eventos = $result->fetch_all(MYSQLI_ASSOC);
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $participante_id = (int)$_POST['participante_id'];
        $evento_id = (int)$_POST['evento_id'];

        
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM inscricoes WHERE participante_id = ? AND evento_id = ? AND status = 'ativa'");
        $stmt->bind_param("ii", $participante_id, $evento_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['count'];
        $stmt->close();

        if ($count > 0) {
            $error = "Participante já inscrito neste evento!";
        } else {
            
            $stmt = $conn->prepare("SELECT vagas, (SELECT COUNT(*) FROM inscricoes WHERE evento_id = ? AND status = 'ativa') AS inscritos FROM eventos WHERE id = ?");
            $stmt->bind_param("ii", $evento_id, $evento_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $evento = $result->fetch_assoc();
            $stmt->close();

            if ($evento['vagas'] <= $evento['inscritos']) {
                $error = "Não há vagas disponíveis!";
            } else {
                $stmt = $conn->prepare("INSERT INTO inscricoes (participante_id, evento_id, data_inscricao, status) VALUES (?, ?, NOW(), 'ativa')");
                $stmt->bind_param("ii", $participante_id, $evento_id);
                if ($stmt->execute()) {
                    header("Location: inscricao_list.php");
                    exit;
                } else {
                    $error = "Erro: " . $conn->error;
                }
                $stmt->close();
            }
        }
    } elseif ($action === 'cancel' && $id) {
        $stmt = $conn->prepare("UPDATE inscricoes SET status = 'cancelada' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: inscricao_list.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Inscrição</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; }
        select { width: 100%; padding: 8px; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Nova Inscrição</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Participante</label>
            <select name="participante_id" required>
                <option value="">Selecione</option>
                <?php foreach ($participantes as $participante): ?>
                <option value="<?php echo $participante['id']; ?>"><?php echo htmlspecialchars($participante['nome']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Evento</label>
            <select name="evento_id" required>
                <option value="">Selecione</option>
                <?php foreach ($eventos as $evento): ?>
                <option value="<?php echo $evento['id']; ?>"><?php echo htmlspecialchars($evento['nome']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Inscrever</button>
        <a href="inscricao_list.php">Cancelar</a>
    </form>
</body>
</html>