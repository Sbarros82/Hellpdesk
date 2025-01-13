<?php
require_once 'db_connection.php'; // Inclui a conexão com o banco

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Verifica se todos os campos foram preenchidos
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    // Verifica se o e-mail é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erro: E-mail inválido.");
    }

    // Hash da senha
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepara a consulta SQL
    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
            header("Location: index.php"); // Redireciona para login
            exit();
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: register.php");
    exit();
}
?>
