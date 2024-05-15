<?php
require_once __DIR__ . '/../config/db.php';

class MartialArt
{
    private $conn;
    //private $today;

    public function __construct($conn)
    {
        // Verifica se a conexão é válida
        if ($conn === null) {
            throw new Exception("Conexão com o banco de dados não fornecida.");
        }
        $this->conn = $conn;
        //$this->today = date("Y-m-d H:i:s");
    }

    // Método para criar um novo usuário
    public function create(array $data)
    {
        try {
            // Consulta preparada para evitar SQL Injection
            $stmt = $this->conn->prepare('INSERT INTO martialArts (name, description) VALUES (?, ?)');

            // Binda parâmetros usando o tipo adequado
            $stmt->bind_param('ss', $data['name'], $data['description']);

            $stmt->execute(); // Executa a consulta
            return true; // Sucesso

        } catch (mysqli_sql_exception $e) {
            // Registra erros para análise posterior
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false; // Retorna falso em caso de erro
        }
    }

    // Método para obter todos os usuários
    public function getAll()
    {
        try {
            // Executa a consulta para obter todos os usuários
            $result = $this->conn->query('SELECT * FROM martialArts');

            // Retorna os resultados como uma matriz associativa
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            // Log de erro em caso de falha
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return []; // Retorna um array vazio em caso de erro
        }
    }


    // Método para obter um usuário por ID
    public function getById($id)
    {
        try {
            // Consulta preparada para obter usuário por ID
            $stmt = $this->conn->prepare('SELECT * FROM martialArts WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc(); // Retorna a primeira linha do resultado

        } catch (mysqli_sql_exception $e) {
            // Log de erro em caso de falha
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return null; // Retorna null em caso de erro
        }
    }

    // Método para atualizar um usuário por ID
    public function update(array $data, $id)
    {
        try {
            // Consulta preparada para atualizar usuário por ID
            $stmt = $this->conn->prepare('UPDATE martialArts SET name = ?, description = ? WHERE id = ?');

            $stmt->bind_param('ss', $data['name'], $data['description'], $id);

            $stmt->execute(); // Executa a atualização
            return true; // Sucesso

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log'); // Log de erro
            return false; // Retorna falso em caso de erro
        }
    }

    // Método para deletar um usuário por ID
    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare('DELETE FROM martialArts WHERE id = ?');
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return false;
        }
    }

    public function countAll()
    {
        try {
            $result = $this->conn->query('SELECT COUNT(*) as total FROM martialArts');
            $row = $result->fetch_assoc();

            return $row['total'];
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log');
            return 0;
        }
    }
}
