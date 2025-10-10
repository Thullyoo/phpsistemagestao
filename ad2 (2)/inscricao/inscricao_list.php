<?php
    require_once '../banco/db.php';
    $db = new Database();
    $conn = $db->getConnection();
    $result = $conn->query("SELECT i.id, p.nome AS participante, e.nome AS evento, i.data_inscricao, i.status 
                            FROM inscricoes i 
                            JOIN participantes p ON i.participante_id = p.id 
                            JOIN eventos e ON i.evento_id = e.id");
    $inscricoes = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Inscrições</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { margin-right: 10px; color: blue; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>Inscrições</h2>
    <a href="inscricao_form.php">Nova Inscrição</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Participante</th>
            <th>Evento</th>
            <th>Data de Inscrição</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($inscricoes as $inscricao): ?>
        <tr>
            <td><?php echo htmlspecialchars($inscricao['id']); ?></td>
            <td><?php echo htmlspecialchars($inscricao['participante']); ?></td>
            <td><?php echo htmlspecialchars($inscricao['evento']); ?></td>
            <td><?php echo htmlspecialchars($inscricao['data_inscricao']); ?></td>
            <td><?php echo htmlspecialchars($inscricao['status']); ?></td>
            <td>
                <a href="inscricao_view.php?id=<?php echo $inscricao['id']; ?>">Visualizar</a>
                <a href="inscricao_form.php?action=cancel&id=<?php echo $inscricao['id']; ?>" onclick="return confirm('Confirma o cancelamento?');">Cancelar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="../index.php">Voltar</a>
</body>
</html>