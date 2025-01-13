<?php
// Iniciar a sessão
session_start();

// Conectar ao banco de dados
require_once 'db_connection.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se os campos de 'username' e 'password' estão definidos
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Preparar a consulta SQL para verificar o usuário no banco de dados
        $sql = "SELECT id, role, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Erro ao preparar a consulta: ' . $conn->error);
        }

        // Bind para a consulta preparada
        $stmt->bind_param('s', $username); // 's' para string

        // Executar a consulta
        $stmt->execute();

        // Obter o resultado da consulta
        $stmt->bind_result($user_id, $role, $hashed_password);
        $stmt->fetch();

        // Verificar se o usuário foi encontrado e a senha está correta
        if ($user_id && password_verify($password, $hashed_password)) {
            // Armazenar informações na sessão
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;

            // Redirecionar para o painel apropriado
            if ($role === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: new_ticket.php'); // Novo destino
            }
            exit();
        } else {
            $error_message = 'Usuário ou senha inválidos.';
        }

        // Fechar a consulta
        $stmt->close();
    } else {
        $error_message = 'Preencha todos os campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css"> <!-- CSS -->
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login_process.php" method="POST">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>
        <p>Não possui conta? <a href="register.php">Cadastre-se</a>.</p>
    </div>
</body>
</html>
