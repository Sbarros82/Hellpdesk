<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Conectar ao banco de dados
require_once 'db_connection.php';

// Obter o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Consultar os dados do usuário
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Se o formulário for enviado para alterar a senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar campos
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error_message = 'Todos os campos são obrigatórios.';
    } elseif ($new_password !== $confirm_password) {
        $error_message = 'As senhas não coincidem.';
    } else {
        // Consultar a senha atual do usuário no banco de dados
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Verificar se a senha atual está correta
        if (password_verify($current_password, $hashed_password)) {
            // Criptografar a nova senha
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Atualizar a senha no banco de dados
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $new_hashed_password, $user_id);

            if ($stmt->execute()) {
                $success_message = 'Senha alterada com sucesso!';
            } else {
                $error_message = 'Erro ao alterar a senha. Tente novamente.';
            }

            $stmt->close();
        } else {
            $error_message = 'A senha atual está incorreta.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <div class="perfil-container">
        <h1>Perfil do Usuário</h1>

        <!-- Exibir mensagem de erro ou sucesso -->
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <!-- Informações do Usuário -->
        <div class="user-info">
            <p><strong>Usuário:</strong> <?php echo $username; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
        </div>

        <!-- Formulário para alterar a senha -->
        <h2>Alterar Senha</h2>
        <form method="POST" action="perfil.php">
            <label for="current_password">Senha Atual</label>
            <input type="password" name="current_password" id="current_password" required>

            <label for="new_password">Nova Senha</label>
            <input type="password" name="new_password" id="new_password" required>

            <label for="confirm_password">Confirmar Nova Senha</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit">Alterar Senha</button>
        </form>
    </div>
</body>
</html>
