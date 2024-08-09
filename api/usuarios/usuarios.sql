CREATE DATABASE IF NOT EXISTS usuarios;

USE usuarios;

CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

INSERT INTO usuario (email, senha) VALUES ('admin@gmail.com', '$2b$10$I0ZjGZzcOppcp7MnriaavOxqGzqbsueWz0FfbbEcfIt8W5C9fcC3q');