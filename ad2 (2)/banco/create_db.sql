CREATE DATABASE IF NOT EXISTS sistema_eventos;
USE sistema_eventos;

CREATE TABLE participantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    matricula VARCHAR(20),
    curso VARCHAR(100),
    data_inscricao DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    data_evento DATETIME NOT NULL,
    vagas INT UNSIGNED NOT NULL CHECK (vagas >= 0),
    carga_horaria INT NOT NULL CHECK (carga_horaria >= 0)
);

CREATE TABLE inscricoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participante_id INT NOT NULL,
    evento_id INT NOT NULL,
    data_inscricao DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('ativa','cancelada') NOT NULL DEFAULT 'ativa',
    FOREIGN KEY (participante_id) REFERENCES participantes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (evento_id) REFERENCES eventos(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    UNIQUE (participante_id, evento_id)
);

