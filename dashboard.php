<?php
// Verificar se o usuário está logado e tem permissão de administrador
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Verificar se o usuário é admin
require_once 'db_connection.php';
$user_id = $_SESSION['user_id'];

$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') {
    header('Location: user_dashboard.php'); // Redireciona para o painel do usuário comum
    exit;
}

// Atualizar o status do ticket
if (isset($_POST['update_status'])) {
    $ticket_id = $_POST['ticket_id'];
    $new_status = $_POST['status'];

    // Atualizar o status do ticket no banco de dados
    $sql_update = "UPDATE tickets SET status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('si', $new_status, $ticket_id);
    if ($stmt_update->execute()) {
        $success_message = "Status do ticket atualizado com sucesso!";
    } else {
        $error_message = "Erro ao atualizar o status do ticket. Tente novamente.";
    }
    $stmt_update->close();
}

// Consulta para obter todos os tickets
$sql_tickets = "SELECT t.id, t.subject, t.description, t.priority, t.department, t.created_at, u.username, t.status
                FROM tickets t
                INNER JOIN users u ON t.user_id = u.id";
$stmt_tickets = $conn->prepare($sql_tickets);
$stmt_tickets->execute();
$result = $stmt_tickets->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Administrador</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <h1>Painel Administrativo</h1>

    <!-- Exibir mensagem de sucesso ou erro -->
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Tabela de tickets -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Prioridade</th>
                <th>Setor</th>
                <th>Criado em</th>
                <th>Usuário</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($ticket = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $ticket['id']; ?></td>
                    <td><?php echo $ticket['subject']; ?></td>
                    <td><?php echo $ticket['description']; ?></td>
                    <td><?php echo $ticket['priority']; ?></td>
                    <td><?php echo $ticket['department']; ?></td>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($ticket['created_at'])); ?></td>
                    <td><?php echo $ticket['username']; ?></td>
                    <td><?php echo $ticket['status']; ?></td>
                    <td>
                        <!-- Formulário para alterar o status do ticket -->
                        <form action="dashboard.php" method="POST">
                            <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                            <select name="status" required>
                                <option value="Aberto" <?php if ($ticket['status'] === 'Aberto') echo 'selected'; ?>>Aberto</option>
                                <option value="Em Análise" <?php if ($ticket['status'] === 'Em Análise') echo 'selected'; ?>>Em Análise</option>
                                <option value="Concluído" <?php if ($ticket['status'] === 'Concluído') echo 'selected'; ?>>Concluído</option>
                                <option value="Recusado" <?php if ($ticket['status'] === 'Recusado') echo 'selected'; ?>>Recusado</option>
                            </select>
                            <button type="submit" name="update_status">Alterar Status</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
