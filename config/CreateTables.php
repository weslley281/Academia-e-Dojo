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
        phone VARCHAR(100),
        email VARCHAR(255),
        password VARCHAR(255) UNIQUE,
        cpf VARCHAR(50) UNIQUE NULL,
        type ENUM('admin', 'instructor', 'student'),
        address VARCHAR(255),
        complement VARCHAR(255),
        country VARCHAR(100),
        state VARCHAR(100),
        city VARCHAR(100),
        neighborhood VARCHAR(100),
        postalCode VARCHAR(100),
        maritalStatus VARCHAR(50),
        gender VARCHAR(10),
        birthDate DATE,
        editDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'users' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'users': " . $conn->error;
        }
    }

    public static function createMartialArtsTable($conn)
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS martialArts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) UNIQUE,
            description TEXT(500),
            editDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela de usuários criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'users': " . $conn->error;
        }
    }

    public static function createClassTable($conn)
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS classes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            idMartialArt INT,
            idInstructor INT,
            name VARCHAR(255) UNIQUE,
            description TEXT(500),
            value DECIMAL(10, 2),
            initialHour TIME,
            finalHour TIME,
            editDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'classes' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'classes': " . $conn->error;
        }
    }

    public static function createClassDaysTable($conn)
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS class_days (
            id INT AUTO_INCREMENT PRIMARY KEY,
            class_id INT,
            day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
            FOREIGN KEY (class_id) REFERENCES classes(id)
        );

        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'classes' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'classes': " . $conn->error;
        }
    }

    public static function createClassSalesTable($conn)
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS sales (
            id INT AUTO_INCREMENT PRIMARY KEY,
            userId INT NOT NULL,
            studentId INT NOT NULL,
            total DECIMAL(10, 2) NOT NULL,
            paymentMethod VARCHAR(50) NOT NULL,
            status VARCHAR(50) NOT NULL,
            saleDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (userId) REFERENCES users(id)
        );

        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'classes' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'classes': " . $conn->error;
        }
    }
}
