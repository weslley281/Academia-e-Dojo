<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "./config/db.php";
    require_once "./controllers/UserController.php";

    $name = $_GET["name"];
    $phone = $_GET["phone"];
    $email = $_GET["email"];
    $address = $_GET["address"];
    $complement = $_GET["complement"];
    $country = $_GET["country"];
    $state = $_GET["state"];
    $city = $_GET["city"];
    $neighborhood = $_GET["neighborhood"];
    $postalCode = $_GET["postalCode"];
    $maritalStatus = $_GET["maritalStatus"];
    $gender = $_GET["gender"];
    $isMinor = $_GET["isMinor"];
    $birthDate = $_GET["birthDate"];

    $user = new UserController($conn);
    if ($user->create($name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $postalCode, $maritalStatus, $gender, $isMinor, $birthDate)) {
        header("Location: index.php?page=users&action=success");
        exit;
    } else {
        header("Location: index.php?page=users&action=fail");
        exit;
    }
}
