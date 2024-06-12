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
            id_martial_art INT,
            idInstructor INT,
            name VARCHAR(255) UNIQUE,
            description TEXT(500),
            value DECIMAL(10, 2),
            initialHour TIME,
            finalHour TIME,
            days INT,
            editDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (id_martial_art) REFERENCES martialArts(id),
            FOREIGN KEY (idInstructor) REFERENCES users(id)
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

    public static function createMethodPaymentTable($conn)
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS method_payment (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255),
                processingFee DECIMAL(10, 2) DEFAULT 0,
                editDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'method_payment' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'method_payment': " . $conn->error;
        }
    }

    public static function createCashierTable($conn)
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS cashier (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                cash DECIMAL(10, 2) DEFAULT 0,
                credit DECIMAL(10, 2) DEFAULT 0,
                debit DECIMAL(10, 2) DEFAULT 0,
                deposit DECIMAL(10, 2) DEFAULT 0,
                openedBy INT,
                closedBy INT,
                status ENUM('open', 'close'),
                open TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                close TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (openedBy) REFERENCES users(id),
                FOREIGN KEY (closedBy) REFERENCES users(id)
            );
        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'cashier' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'cashier': " . $conn->error;
        }
    }

    public static function createSalesTable($conn)
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS sales_records (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cashier_id INT NOT NULL,
                user_id INT NOT NULL,
                student_id INT NULL,
                discount DECIMAL(10, 2) NULL,
                amount_paid DECIMAL(10, 2) NULL,
                change_sale DECIMAL(10, 2) NULL,
                total DECIMAL(10, 2) NULL,
                status ENUM('in_process', 'processed', 'canceled'),
                saleDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (cashier_id) REFERENCES cashier(id),
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (student_id) REFERENCES users(id)
            );
        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'sales_records' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'sales_records': " . $conn->error;
        }
    }

    public static function createSalesItemTable($conn)
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS sales_item (
                id INT AUTO_INCREMENT PRIMARY KEY,
                sale_id INT NOT NULL,
                class_id INT NOT NULL,
                FOREIGN KEY (sale_id) REFERENCES sales_records(id),
                FOREIGN KEY (class_id) REFERENCES classes(id)
            );
        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'sales_item' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'sales_item': " . $conn->error;
        }
    }

    public static function createSalesPaymentItemTable($conn)
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS sales_payment_item (
                id INT AUTO_INCREMENT PRIMARY KEY,
                sale_id INT NOT NULL,
                payment_method_id INT NOT NULL,
                amount_paid DECIMAL(10, 2) NOT NULL,
                FOREIGN KEY (sale_id) REFERENCES sales_records(id),
                FOREIGN KEY (payment_method_id) REFERENCES method_payment(id)
            );
        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'sales_item' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'sales_item': " . $conn->error;
        }
    }

    public static function createExpirationItemTable($conn)
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS expiration (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_id INT NOT NULL,
                class_id INT NOT NULL,
                createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                expirationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (student_id) REFERENCES users(id),
                FOREIGN KEY (class_id) REFERENCES classes(id)
            );
        ";

        if ($conn->query($sql) === true) {
            //echo "Tabela 'sales_item' criada com sucesso.";
        } else {
            echo "Erro ao criar tabela 'sales_item': " . $conn->error;
        }
    }
}
