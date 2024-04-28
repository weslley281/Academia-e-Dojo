<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $user;

    public function __construct($conn)
    {
        $this->user = new User($conn);
    }

    public function create($data)
    {
        return $this->user->create($data);
    }

    public function read()
    {
        return $this->user->getAll();
    }

    public function get($id)
    {
        return $this->user->getById($id);
    }

    public function update($data, $id)
    {
        return $this->user->update($data, $id);
    }

    public function delete($id)
    {
        return $this->user->delete($id);
    }
}
