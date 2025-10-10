<?php
    require_once 'banco/db.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gerenciamento de Eventos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 10px; text-decoration: none; color: blue; }
        nav a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Sistema de Gerenciamento de Eventos</h1>
    <nav>
        <a href="participante/participante_list.php">Gerenciar Participantes</a>
        <a href="evento/evento_list.php">Gerenciar Eventos</a>
        <a href="inscricao/inscricao_list.php">Gerenciar Inscrições</a>
    </nav>
</body>
</html>