<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "./config/db.php";
    require_once "./controllers/UserController.php";
    $user = new UserController($conn);

    $id = $_POST["id"];

    if (isset($_GET["action"]) && $_GET["action"] == "create") {

        if (isset($_POST["isMinor"]) && $_POST["isMinor"] == "true") {
            $isMinor = 1;
        } else {
            $isMinor = 0;
        }

        $data = [
            "name" => $_POST["name"],
            "phone" => $_POST["phone"],
            "email" => $_POST["email"],
            "address" => $_POST["address"],
            "complement" => $_POST["complement"],
            "country" => $_POST["country"],
            "state" => $_POST["state"],
            "city" => $_POST["city"],
            "neighborhood" => $_POST["neighborhood"],
            "postalCode" => $_POST["postalCode"],
            "maritalStatus" => $_POST["maritalStatus"],
            "gender" => $_POST["gender"],
            "birthDate" => $_POST["birthDate"],
            "isMinor" => $isMinor,
        ];

        if ($user->create($data)) {
            header("Location: index.php?page=users&action=success");
            exit;
        } else {
            header("Location: index.php?page=users&action=fail");
            exit;
        }
    } elseif (isset($_GET["action"]) && $_GET["action"] == "update") {

        if (isset($_POST["isMinor"]) && $_POST["isMinor"] == "true") {
            $isMinor = 1;
        } else {
            $isMinor = 0;
        }

        $data = [
            "name" => $_POST["name"],
            "phone" => $_POST["phone"],
            "email" => $_POST["email"],
            "address" => $_POST["address"],
            "complement" => $_POST["complement"],
            "country" => $_POST["country"],
            "state" => $_POST["state"],
            "city" => $_POST["city"],
            "neighborhood" => $_POST["neighborhood"],
            "postalCode" => $_POST["postalCode"],
            "maritalStatus" => $_POST["maritalStatus"],
            "gender" => $_POST["gender"],
            "birthDate" => $_POST["birthDate"],
            "isMinor" => $isMinor,
        ];

        var_dump($data);

        if ($user->update($data, $id)) {
            //header("Location: index.php?page=users&action=saved");
            exit;
        } else {
            //header("Location: index.php?page=users&action=fail");
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
