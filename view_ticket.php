<?php
require_once 'db_connection.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Verifica se o ID do ticket foi passado na URL
if (isset($_GET['id'])) {
    $ticket_id = $_GET['id'];

    // Prepara a consulta para pegar os detalhes do ticket
    $sql = "SELECT subject, description, priority, department, created_at, status FROM tickets WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o ticket foi encontrado
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($subject, $description, $priority, $department, $created_at, $status);
        $stmt->fetch();  // Preenche as variáveis com os dados do ticket
    } else {
        echo "Erro: Ticket não encontrado.";
        exit();
    }

    $stmt->close();
} else {
    echo "Erro: ID de ticket inválido.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/ticket_details.css">
    <title>Detalhes do Ticket</title>
</head>
<body>
    <div class="container">
        <h1>Detalhes do Ticket</h1>

        <?php if (isset($subject)): ?>
            <div class="ticket-details">
                <h3><?php echo htmlspecialchars($subject); ?></h3>
                <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($description)); ?></p>
                <p><strong>Prioridade:</strong> <?php echo htmlspecialchars($priority); ?></p>
                <p><strong>Setor:</strong> <?php echo htmlspecialchars($department); ?></p>
                <p><strong>Criado em:</strong> <?php echo date("d/m/Y H:i", strtotime($created_at)); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($status); ?></p> <!-- Status do ticket -->
            </div>
        <?php else: ?>
            <p>Erro ao exibir os detalhes do ticket.</p>
        <?php endif; ?>

        <a href="new_ticket.php">Voltar</a>
    </div>
</body>
</html>
