<?php
require_once __DIR__ . '/../config/db.php';

class SalesRecord
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
            $stmt = $this->conn->prepare('INSERT INTO sales_records (cashierId, user_id, student_id, class_id, total, paymentMethodId, status) VALUES (?, ?, ?, ?, ?, ?, ?)');

            $stmt->bind_param('iiiddis', $data['cashierId'], $data['user_id'], $data['student_id'], $data['class_id'], $data['total'], $data['paymentMethodId'], $data['status']);

            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM sales_records WHERE id = ?');
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
            $stmt = $this->conn->prepare('UPDATE sales_records SET cashierId = ?, user_id = ?, student_id = ?, class_id = ?, total = ?, paymentMethodId = ?, status = ? WHERE id = ?');

            $stmt->bind_param('iiiddisi', $data['cashierId'], $data['user_id'], $data['student_id'], $data['class_id'], $data['total'], $data['paymentMethodId'], $data['status'], $id);

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
            $stmt = $this->conn->prepare('DELETE FROM sales_records WHERE id = ?');
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }

    public function getAll()
    {
        try {
            $result = $this->conn->query('SELECT * FROM sales_records');
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return [];
        }
    }

    public function countAll()
    {
        try {
            $result = $this->conn->query('SELECT COUNT(*) as total FROM sales_records');
            $row = $result->fetch_assoc();
            return $row['total'];
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return 0;
        }
    }
}
