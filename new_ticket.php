<?php
// Database connection
require_once 'db_connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Verifique se o diretório de uploads existe e, se não, crie-o
$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true); // Cria o diretório com permissões de leitura/escrita
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $department = $_POST['department'];

    // Verifica se o arquivo foi enviado e se não houve erros no upload
    $file_path = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['file']['name']);
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_path = $upload_dir . $file_name;

        // Move o arquivo para o diretório de uploads
        if (!move_uploaded_file($file_tmp_name, $file_path)) {
            $error_message = "Erro ao mover o arquivo para o diretório de uploads.";
        }
    }

    // Define a consulta SQL dependendo da existência de um arquivo
    if ($file_path) {
        $sql = "INSERT INTO tickets (user_id, subject, description, priority, department, file_path) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('isssss', $user_id, $subject, $description, $priority, $department, $file_path);
        }
    } else {
        $sql = "INSERT INTO tickets (user_id, subject, description, priority, department) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('issss', $user_id, $subject, $description, $priority, $department);
        }
    }

    // Execute the statement and check for success
    if ($stmt && $stmt->execute()) {
        $success_message = "Ticket aberto com sucesso!";
    } else {
        $error_message = "Erro ao abrir o ticket. Tente novamente.";
    }

    // Close the statement
    if ($stmt) {
        $stmt->close();
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir Novo Ticket</title>
    <link rel="stylesheet" href="css/new_ticket.css"> <!-- Certifique-se de que o caminho do CSS está correto -->
</head>
<body>
    <div class="container">
        <h1>Abrir Novo Ticket</h1>

        <!-- Exibir mensagem de sucesso ou erro, se existirem -->
        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Formulário para abertura do ticket -->
        <form action="new_ticket.php" method="POST" enctype="multipart/form-data">
            <label for="subject">Título</label>
            <input type="text" id="subject" name="subject" required>

            <label for="description">Descrição</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="priority">Prioridade</label>
            <select id="priority" name="priority" required>
                <option value="Baixa">Baixa</option>
                <option value="Média">Média</option>
                <option value="Alta">Alta</option>
            </select>

            <label for="department">Setor</label>
            <input type="text" id="department" name="department" required>

            <!-- Campo para upload de arquivos -->
            <label for="file">Anexar Arquivo</label>
            <input type="file" id="file" name="file">

            <button type="submit">Abrir Ticket</button>
        </form>

        <a href="user_dashboard.php">Voltar ao Dashboard</a>
    </div>
</body>
</html>
