<?php
    require_once '../banco/db.php';
    $db = new Database();
    $conn = $db->getConnection();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $stmt = $conn->prepare("SELECT i.id, p.nome AS participante, e.nome AS evento, i.data_inscricao, i.status 
                            FROM inscricoes i 
                            JOIN participantes p ON i.participante_id = p.id 
                            JOIN eventos e ON i.evento_id = e.id 
                            WHERE i.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $inscricao = $stmt->get_result()->fetch_assoc();
    $stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Inscrição</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .detail { margin-bottom: 10px; }
        a { color: blue; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>Detalhes da Inscrição</h2>
    <?php if ($inscricao): ?>
    <div class="detail"><strong>ID:</strong> <?php echo htmlspecialchars($inscricao['id']); ?></div>
    <div class="detail"><strong>Participante:</strong> <?php echo htmlspecialchars($inscricao['participante']); ?></div>
    <div class="detail"><strong>Evento:</strong> <?php echo htmlspecialchars($inscricao['evento']); ?></div>
    <div class="detail"><strong>Data de Inscrição:</strong> <?php echo htmlspecialchars($inscricao['data_inscricao']); ?></div>
    <div class="detail"><strong>Status:</strong> <?php echo htmlspecialchars($inscricao['status']); ?></div>
    <?php else: ?>
    <p>Inscrição não encontrada.</p>
    <?php endif; ?>
    <a href="inscricao_list.php">Voltar</a>
</body>
</html>