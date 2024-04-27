<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "./config/db.php";
    require_once "./controllers/UserController.php";
    $user = new UserController($conn);

    $id = $_POST["id"];

    if (isset($_GET["action"]) && $_GET["action"] == "create") {

        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $complement = $_POST["complement"];
        $country = $_POST["country"];
        $state = $_POST["state"];
        $city = $_POST["city"];
        $neighborhood = $_POST["neighborhood"];
        $postalCode = $_POST["postalCode"];
        $maritalStatus = $_POST["maritalStatus"];
        $gender = $_POST["gender"];
        $birthDate = $_POST["birthDate"];

        if (isset($_POST["isMinor"]) && $_POST["isMinor"] == "true") {
            $isMinor = 1;
        } else {
            $isMinor = 0;
        }

        if ($user->create($name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $postalCode, $maritalStatus, $gender, $isMinor, $birthDate)) {
            header("Location: index.php?page=users&action=success");
            exit;
        } else {
            header("Location: index.php?page=users&action=fail");
            exit;
        }
    } elseif (isset($_GET["action"]) && $_GET["action"] == "update") {

        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $complement = $_POST["complement"];
        $country = $_POST["country"];
        $state = $_POST["state"];
        $city = $_POST["city"];
        $neighborhood = $_POST["neighborhood"];
        $postalCode = $_POST["postalCode"];
        $maritalStatus = $_POST["maritalStatus"];
        $gender = $_POST["gender"];
        $birthDate = $_POST["birthDate"];

        if (isset($_POST["isMinor"]) && $_POST["isMinor"] == "true") {
            $isMinor = 1;
        } else {
            $isMinor = 0;
        }

        if ($user->update($id, $name, $phone, $email, $address, $complement, $country, $state, $city, $neighborhood, $postalCode, $maritalStatus, $gender, $isMinor, $birthDate)) {
            header("Location: index.php?page=users&action=saved");
            exit;
        } else {
            header("Location: index.php?page=users&action=fail");
            exit;
        }
    } elseif (isset($_GET["action"]) && $_GET["action"] == "delete") {
        if ($user->delete($id)) {
            header("Location: index.php?page=users&action=deleted");
            exit;
        } else {
            header("Location: index.php?page=users&action=fail");
            exit;
        }
    }
}
