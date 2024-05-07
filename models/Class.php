<?php
require_once __DIR__ . '/../config/db.php';

class ClassModel
{
    private $conn;

    public function __construct($conn)
    {
        if ($conn === null) {
            throw new Exception("Conexão com o banco de dados não fornecida.");
        }
        $this->conn = $conn;
    }

    public function create(array $data)
    {
        try {
            $stmt = $this->conn->prepare(
                'INSERT INTO classes (idMartialArt, idInstructor, name, description, initialHour, finalHour)
                 VALUES (?, ?, ?, ?, ?, ?)'
            );

            $stmt->bind_param(
                'iissss',
                $data['idMartialArt'],
                $data['idInstructor'],
                $data['name'],
                $data['description'],
                $data['initialHour'],
                $data['finalHour']
            );

            $stmt->execute();
            return true;

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }

    public function getAll()
    {
        try {
            $result = $this->conn->query('SELECT * FROM classes');
            return $result->fetch_all(MYSQLI_ASSOC);

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return [];
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM classes WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return null;
        }
    }

    public function update(array $data, $id)
    {
        try {
            $stmt = $this->conn->prepare(
                'UPDATE classes SET idMartialArt = ?, idInstructor = ?, name = ?, description = ?, initialHour = ?, finalHour = ? WHERE id = ?'
            );

            $stmt->bind_param(
                'iissssi',
                $data['idMartialArt'],
                $data['idInstructor'],
                $data['name'],
                $data['description'],
                $data['initialHour'],
                $data['finalHour'],
                $id
            );

            $stmt->execute();
            return true;

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare('DELETE FROM classes WHERE id = ?');
            $stmt->bind_param('i', $id);
            return $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }
}
