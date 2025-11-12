CREATE DATABASE bancoAssault;
USE bancoAssault;

CREATE TABLE localizacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_hora DATETIME NOT NULL,
    latitude DECIMAL(10, 7) NOT NULL,
    longitude DECIMAL(10, 7) NOT NULL
);
