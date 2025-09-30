<?php

$host = "0.0.0.0:3310";
$database = "sistema_gestao";
$user = "usuario";
$password = "senha123";


$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn){
    die("Falha na conexao: " . mysqli_connect_error());
}

echo "Conexao realizada com sucesso";

mysql_close($conn);

?>