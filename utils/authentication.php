<?php
session_start(); // Inicia a sessão para armazenar dados de sessão
require_once 'config/db.php'; // Conexão com o banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $limitAttempts = 3;

    if (!isset($_SESSION['attempts'])) {
        $_SESSION['attempts'] = 0;
    }

    if (isset($_SESSION['block']) && $_SESSION['block'] > time()) {
        $timeLeft = $_SESSION['block'] - time();
        $message = "Usuário bloqueado, tente novamente em " . gmdate("H:i:s", $timeLeft);
        echo "<script language='javascript'>window.alert('$message'); </script>";
        echo "<script language='javascript'>window.location='../views/login.php'; </script>";
        exit();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_POST['usuario'], $_POST['senha'])) {
        // Busca o usuário no banco de dados
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Armazena informações na sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Se a senha for temporária, redireciona para a página de atualização
            if ($password === $temporaryPassword) {
                header("Location: update_password.php");
            } else {
                // Redireciona para a página principal após autenticação bem-sucedida
                header("Location: index.php?");
            }
            exit;
        } else {
            $errorMessage = "E-mail ou senha incorretos.";
            header("Location: index.php");
        }
    } else {
        $errorMessage = "E-mail ou senha incorretos.";
        header("Location: index.php");
    }
}
