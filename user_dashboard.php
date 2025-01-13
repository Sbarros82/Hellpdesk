<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

try {
    if ($role === 'admin') {
        $sql = "SELECT t.id, t.subject, t.status, t.created_at, u.username 
                FROM tickets t 
                JOIN users u ON t.user_id = u.id 
                ORDER BY t.created_at DESC";
        $stmt = $conn->prepare($sql);
    } else {
        $sql = "SELECT id, subject, status, created_at FROM tickets WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }

    $stmt->execute();
    $stmt->store_result();

    if ($role === 'admin') {
        $stmt->bind_result($ticket_id, $subject, $status, $created_at, $username);
    } else {
        $stmt->bind_result($ticket_id, $subject, $status, $created_at);
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Tickets</title>
  <link rel="stylesheet" href="css/user_dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
  <div class="container">
    <div class="cabecalho">
      <h1>Painel de Tickets</h1>
      <a href="new_ticket.php"><i class="fa-solid fa-plus"></i> Abrir Novo Ticket</a>
    </div>
    <hr>
    <h2>Tickets Abertos</h2>

    <?php
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $status_class = '';
        switch ($status) {
          case 'Aberto':
            $status_class = 'status-aberto';
            break;
          case 'Em Andamento':
            $status_class = 'status-em-analise';
            break;
          case 'Resolvido':
            $status_class = 'status-concluido';
            break;
          case 'Fechado':
            $status_class = 'status-recusado';
            break;
        }
        echo "<div class='ticket-card'>";
        echo "<h3>" . htmlspecialchars($subject) . "</h3>";
        echo "<p><strong>Status:</strong> <span class='$status_class'>" . htmlspecialchars($status) . "</span></p>";
        echo "<p><strong>Criado em:</strong> " . date("d/m/Y H:i", strtotime($created_at)) . "</p>";
        if ($role === 'admin') {
          echo "<p><strong>Usuário:</strong> " . htmlspecialchars($username) . "</p>";
        }
        echo "<a href='view_ticket.php?id=" . $ticket_id . "' class='button'><i class='fa-solid fa-eye'></i> Ver Detalhes</a>";
        echo "</div>";
      }
    } else {
      echo "<p>Nenhum ticket encontrado.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
  </div>
</body>
</html>