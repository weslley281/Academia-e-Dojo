<?php
require_once __DIR__ . '/../config/db.php';

class MonthlyFee
{
    private $conn;

    public function __construct($conn)
    {
        if ($conn === null) {
            throw new Exception("Conexão com o banco de dados não fornecida.");
        }
        $this->conn = $conn;
    }

    /**
     * Cria um novo registro de mensalidade.
     * @param array $data Dados da mensalidade (student_id, modality_id, due_date, amount_due, status)
     * @return bool
     */
    public function create(array $data): bool
    {
        try {
            $stmt = $this->conn->prepare(
                'INSERT INTO monthly_fees (student_id, modality_id, due_date, amount_due, status)
                 VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->bind_param(
                'iisds',
                $data['student_id'],
                $data['modality_id'],
                $data['due_date'],
                $data['amount_due'],
                $data['status']
            );
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }

    /**
     * Busca uma mensalidade pelo ID.
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        try {
            $sql = "SELECT mf.*, u.name as student_name, m.name as modality_name 
                    FROM monthly_fees mf
                    JOIN users u ON mf.student_id = u.id
                    JOIN modalities m ON mf.modality_id = m.id
                    WHERE mf.id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return null;
        }
    }

    public function getMonthlyFeesByID(int $id): ?array
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM monthly_fees WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return null;
        }
    }

    /**
     * Busca todas as mensalidades de um aluno específico.
     * @param int $student_id
     * @return array
     */
    public function getByStudentId(int $student_id): array
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM monthly_fees WHERE student_id = ? ORDER BY due_date DESC');
            $stmt->bind_param('i', $student_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return [];
        }
    }
    
    /**
     * Busca todas as mensalidades com um status específico (ex: 'pending', 'overdue').
     * @param string $status
     * @return array
     */
    public function getByStatus(string $status): array
    {
        try {
            $stmt = $this->conn->prepare('SELECT mf.*, u.name as student_name, m.name as modality_name FROM monthly_fees mf JOIN users u ON mf.student_id = u.id JOIN modalities m ON mf.modality_id = m.id WHERE mf.status = ? ORDER BY mf.due_date ASC');
            $stmt->bind_param('s', $status);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return [];
        }
    }

    public function turnStatusToOverdue(): void
    {
        try {
            $today = date('Y-m-d');
            //echo "UPDATE monthly_fees SET status = 'overdue' WHERE due_date < $today";
            $stmt = $this->conn->prepare("UPDATE monthly_fees SET status = 'overdue' WHERE due_date < ?");
            $stmt->bind_param('s', $today);
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
        }
    }

    /**
     * Atualiza o status e os dados de pagamento de uma mensalidade.
     * @param int $id
     * @param array $data (payment_date, amount_paid, status)
     * @return bool
     */
    public function updatePayment(int $id, array $data): bool
    {
        try {
            $stmt = $this->conn->prepare(
                'UPDATE monthly_fees SET payment_date = ?, amount_paid = ?, status = ? WHERE id = ?'
            );
            $stmt->bind_param(
                'sdsi',
                $data['payment_date'],
                $data['amount_paid'],
                $data['status'],
                $id
            );
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }

    public function updateDaysUntilDue(int $id, int $days): bool
    {
        $today = date('Y-m-d');
        try {
            $stmt = $this->conn->prepare(
                'UPDATE monthly_fees SET due_date = DATE_ADD(?, INTERVAL ? DAY) WHERE id = ?'
            );
            $stmt->bind_param('sii', $today, $days, $id);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }

    /**
     * Deleta um registro de mensalidade.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare('DELETE FROM monthly_fees WHERE id = ?');
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }
}
?>