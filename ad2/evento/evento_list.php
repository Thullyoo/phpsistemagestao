<?php
    require_once '../banco/db.php';
    $db = new Database();
    $conn = $db->getConnection();
    $result = $conn->query("SELECT * FROM eventos");
    $eventos = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Eventos</title>
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
    <h2>Eventos</h2>
    <a href="evento_form.php">Novo Evento</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Data</th>
            <th>Vagas</th>
            <th>Carga Horária</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($eventos as $evento): ?>
        <tr>
            <td><?php echo htmlspecialchars($evento['id']); ?></td>
            <td><?php echo htmlspecialchars($evento['nome']); ?></td>
            <td><?php echo htmlspecialchars($evento['descricao']); ?></td>
            <td><?php echo htmlspecialchars($evento['data_evento']); ?></td>
            <td><?php echo htmlspecialchars($evento['vagas']); ?></td>
            <td><?php echo htmlspecialchars($evento['carga_horaria']); ?></td>
            <td>
                <a href="evento_form.php?id=<?php echo $evento['id']; ?>">Editar</a>
                <a href="evento_form.php?action=delete&id=<?php echo $evento['id']; ?>" onclick="return confirm('Confirma a exclusão?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="../index.php">Voltar</a>
</body>
</html>