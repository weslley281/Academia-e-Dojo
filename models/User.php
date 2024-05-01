<?php
require_once __DIR__ . '/../config/db.php';

class User
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
            $stmt = $this->conn->prepare(
                'INSERT INTO users (name, phone, email, address, complement, country, state, city, neighborhood, postalCode, maritalStatus, gender, birthDate, password)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );

            // Binda parâmetros usando o tipo adequado
            $stmt->bind_param(
                'ssssssssssssss',
                $data['name'],
                $data['phone'],
                $data['email'],
                $data['address'],
                $data['complement'],
                $data['country'],
                $data['state'],
                $data['city'],
                $data['neighborhood'],
                $data['postalCode'],
                $data['maritalStatus'],
                $data['gender'],
                $data['birthDate'],
                $data['password'],
                //$this->today,
                //$this->today
            );

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
            $result = $this->conn->query('SELECT * FROM users');

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
            $stmt = $this->conn->prepare('SELECT * FROM users WHERE id = ?');
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
            $stmt = $this->conn->prepare(
                'UPDATE users SET name = ?, phone = ?, email = ?, address = ?, complement = ?, country = ?, state = ?, city = ?, neighborhood = ?, postalCode = ?, maritalStatus = ?, gender = ?, birthDate = ? WHERE id = ?'
            );

            $stmt->bind_param(
                'sssssssssssssi',
                $data['name'],
                $data['phone'],
                $data['email'],
                $data['address'],
                $data['complement'],
                $data['country'],
                $data['state'],
                $data['city'],
                $data['neighborhood'],
                $data['postalCode'],
                $data['maritalStatus'],
                $data['gender'],
                $data['birthDate'],
                //$this->today,
                $id
            );

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
            $stmt = $this->conn->prepare('DELETE FROM users WHERE id = ?');
            $stmt->bind_param('i', $id);
            return $stmt->execute(); // Retorna true se a exclusão for bem-sucedida

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/errors.log'); // Log de erro
            return false; // Retorna falso em caso de erro
        }
    }
}
