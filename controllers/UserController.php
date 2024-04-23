<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $user;

    public function __construct($conn)
    {
        $this->user = new User($conn);
    }

    public function create($name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $postalCode, $maritalStatus, $gender, $isMinor, $birthDate)
    {
        return $this->user->create($name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $postalCode, $maritalStatus, $gender, $isMinor, $birthDate);
    }

    public function read()
    {
        return $this->user->getAll();
    }

    public function get($id)
    {
        return $this->user->getById($id);
    }

    public function update($id, $name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $postalCode, $maritalStatus, $gender, $isMinor, $birthDate)
    {
        return $this->user->update($id, $name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $postalCode, $maritalStatus, $gender, $isMinor, $birthDate);
    }

    public function delete($id)
    {
        return $this->user->delete($id);
    }
}
