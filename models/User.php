<?php
require_once __DIR__ . '/../config/db.php';

class User
{
    private $conn;
    private $today;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->today = date("Y-m-d H:i:s");
    }

    public function create($data)
    {
        try {
            $stmt = $this->conn->prepare('INSERT INTO users (name, phone, email, address, complement, country, state, city, neighborhood, postalCode, maritalStatus, gender, isMinor, birthDate, editDate, createDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('ssssssssssssisss', $data["name"], $data["phone"], $data["email"], $data["address"], $data["complement"], $data["country"], $data["state"], $data["city"], $data["neighborhood"], $data["postalCode"], $data["maritalStatus"], $data["gender"], $data["isMinor"], $data["birthDate"], $this->today, $this->today);
            $stmt->execute();

            return true; // Sucesso
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, 'errors.log');
            return false;
        }
    }

    public function getAll()
    {
        try {
            $result = $this->conn->query('SELECT * FROM users');
            return $result->fetch_all(MYSQLI_ASSOC);

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, 'errors.log');
            return []; // Retorna um array vazio em caso de erro
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, 'errors.log');
            return []; // Retorna um array vazio em caso de erro
        }
    }

    public function update($data, $id)
    {
        try {
            $stmt = $this->conn->prepare('UPDATE users SET name = ?, phone = ?, email = ?, address = ?, complement = ?, country = ?, state = ?, city = ?, neighborhood = ?, postalCode = ?, maritalStatus = ?, gender = ?, isMinor = ?, birthDate = ?, editDate= ? WHERE id = ?');
            $stmt->bind_param('sssssssssssisssi', $data["name"], $data["phone"], $data["email"], $data["address"], $data["complement"], $data["country"], $data["state"], $data["city"], $data["neighborhood"], $data["postalCode"], $data["maritalStatus"], $data["gender"], $data["isMinor"], $data["birthDate"], $this->today, $id);
            $stmt->execute();

            $query = sprintf(
                'UPDATE users SET name = %s, phone = %s, email = %s, address = %s, complement = %s, country = %s, state = %s, city = %s, neighborhood = %s, postalCode = %s, maritalStatus = %s, gender = %s, isMinor = %s, birthDate = %s, editDate = %s WHERE id = %s',
                $data["name"], $data["phone"], $data["email"], $data["address"], $data["complement"], $data["country"], $data["state"], $data["city"], $data["neighborhood"], $data["postalCode"], $data["maritalStatus"], $data["gender"], $data["isMinor"], $data["birthDate"], $this->today, $id
            );
            echo $query;

            return true;

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, 'errors.log');
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare('DELETE FROM users WHERE id = ?');
            $stmt->bind_param('i', $id);

            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, 'errors.log');
            return false;
        }
    }
}
