<?php
require_once __DIR__ . '/db.php';

class CreateTables
{
    public static function createUsersTable($conn)
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            phone VARCHAR(30),
            email VARCHAR(255),
            address VARCHAR(255),
            complement VARCHAR(255),
            country VARCHAR(100),
            state VARCHAR(100),
            city VARCHAR(100),
            neighborhood VARCHAR(100),
            maritalStatus VARCHAR(50),
            gender VARCHAR(10),
            isMinor TINYINT(1),
            birthDate DATE,
            editDate DATETIME,
            createDate DATETIME
        );
        ";

        if ($conn->query($sql) === true) {
            echo "Tabela de usuários criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'users': " . $conn->error;
        }
    }
}
