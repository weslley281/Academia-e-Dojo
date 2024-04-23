<?php
require_once __DIR__ . '/../config/db.php';

class User
{
    private $conn;
    private $today;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->today = Date("Y:m:d");
    }

    public function create($name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $maritalStatus, $gender, $isMinor, $birthDate)
    {
        $stmt = $this->conn->prepare('INSERT INTO users (name, phone, email, address, complement, country, state, city, neighborhood, maritalStatus, gender, isMinor, birthDate, editDate, createDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssssssssssbsss', $name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $maritalStatus, $gender, $isMinor, $birthDate, $this->today, $this->today);
        return $stmt->execute();
    }

    public function getAll()
    {
        $result = $this->conn->query('SELECT * FROM users');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $maritalStatus, $gender, $isMinor, $birthDate)
    {
        $stmt = $this->conn->prepare('UPDATE users SET name = ?, email = ?, address = ?, complement = ?, country = ?, state = ?, city = ?, neighborhood = ?, maritalStatus = ?, gender = ?, isMinor = ?, birthDate = ?, editDate= ? WHERE id = ?');
        $stmt->bind_param('ssssssssssbssi', $name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $maritalStatus, $gender, $isMinor, $birthDate, $this->today);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
