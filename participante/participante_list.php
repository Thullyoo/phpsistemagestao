<?php
include("../banco/db.php");


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM participantes WHERE id = $id");
    header("Location: participante_list.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM participantes ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Participantes</title>
</head>
<body>
    <h2>Participantes</h2>
    <a href="participante_form.php">Novo Participante</a>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th><th>Nome</th><th>Email</th><th>Matrícula</th><th>Curso</th><th>Ações</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nome'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['matricula'] ?></td>
            <td><?= $row['curso'] ?></td>
            <td>
                <a href="participante_form.php?id=<?= $row['id'] ?>">Editar</a> | 
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Excluir participante?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
