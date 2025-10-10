<?php
    require_once '../banco/db.php';
    $db = new Database();
    $conn = $db->getConnection();
    $result = $conn->query("SELECT * FROM participantes");
    $participantes = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Participantes</title>
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
    <h2>Participantes</h2>
    <a href="participante_form.php">Novo Participante</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Matrícula</th>
            <th>Curso</th>
            <th>Data de Inscrição</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($participantes as $participante): ?>
        <tr>
            <td><?php echo htmlspecialchars($participante['id']); ?></td>
            <td><?php echo htmlspecialchars($participante['nome']); ?></td>
            <td><?php echo htmlspecialchars($participante['email']); ?></td>
            <td><?php echo htmlspecialchars($participante['matricula']); ?></td>
            <td><?php echo htmlspecialchars($participante['curso']); ?></td>
            <td><?php echo htmlspecialchars($participante['data_inscricao']); ?></td>
            <td>
                <a href="participante_form.php?id=<?php echo $participante['id']; ?>">Editar</a>
                <a href="participante_form.php?action=delete&id=<?php echo $participante['id']; ?>" onclick="return confirm('Confirma a exclusão?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="../index.php">Voltar</a>
</body>
</html>