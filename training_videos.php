<?php
session_start();

// Verificar se o usuário está logado e definir o papel
if (!isset($_SESSION['user_role'])) {
    header('Location: login.php'); // Redirecionar para login se não estiver logado
    exit();
}

$user_role = $_SESSION['user_role']; // 'admin' ou 'user'
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treinamentos Corporativos</title>
    <link rel="stylesheet" href="training_videos.css"> <!-- Importando o CSS externo -->
</head>
<body>
<div class="container">
    <h1>Treinamentos Corporativos</h1>

    <!-- Exibição dos Vídeos -->
    <h2>Vídeos Disponíveis</h2>
    <?php
    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'help'); // Substitua pelas credenciais do seu banco
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Buscar vídeos no banco de dados
    $query = "SELECT * FROM videos ORDER BY uploaded_at DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='video'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<video controls src='" . htmlspecialchars($row['video_url']) . "'></video>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<small>Publicado em: " . htmlspecialchars($row['uploaded_at']) . "</small>";
            echo "</div>";
        }
    } else {
        echo "<p>Nenhum vídeo disponível.</p>";
    }

    $conn->close();
    ?>

    <!-- Formulário de Upload para Administradores -->
    <?php if ($user_role === 'admin') : ?>
        <h2>Enviar Novo Vídeo</h2>
        <form action="upload_video.php" method="POST" enctype="multipart/form-data">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="4"></textarea>

            <label for="video">Selecione o Vídeo:</label>
            <input type="file" id="video" name="video" accept="video/*" required>

            <button type="submit">Fazer Upload</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
