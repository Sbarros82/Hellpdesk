<?php
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$username = $_SESSION['username'];

$sql = "SELECT COUNT(*) FROM tickets WHERE status = 'Aberto'";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Erro ao preparar consulta: " . $conn->error;
} else {
    $stmt->execute();
    $stmt->bind_result($new_updates);
    $stmt->fetch();
}
?>