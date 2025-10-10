<?php

class Database {
    private $host = '0.0.0.0:3306';
    private $database = 'sistema_eventos';
    private $user = 'root';
    private $password = 'NovaSenha123@';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Erro na conexão: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

?>