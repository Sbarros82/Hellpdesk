<?php
require_once 'db_connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega o e-mail e a senha do formulário, removendo espaços em branco
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verifica se os campos estão preenchidos
    if (empty($email) || empty($password)) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    // Consulta o banco de dados para verificar as credenciais
    $sql = "SELECT id, username, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Se o usuário for encontrado
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashedPassword, $role);
            $stmt->fetch();

            // Verifica a senha
            if (password_verify($password, $hashedPassword)) {
                // Armazena as informações do usuário na sessão
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                // Redireciona para a página de Dashboard dependendo do papel (role) do usuário
                if ($role === 'admin') {
                    // Se o usuário for administrador, redireciona para o dashboard do administrador
                    header("Location: dashboard.php");
                    exit();
                } else {
                    // Caso contrário, redireciona para a página do usuário comum
                    header("Location:new_ticket.php");
                    exit();
                }
            } else {
                echo "Erro: Senha incorreta.";
            }
        } else {
            echo "Erro: Usuário não encontrado.";
        }

        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    // Se não for uma requisição POST, redireciona para a página de login
    header("Location: portal.php");
    exit();
}
?>
