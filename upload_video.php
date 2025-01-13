<?php
session_start();

// Verificar se o usuário é administrador
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: training_videos.php'); // Redirecionar para a página principal
    exit();
}

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'training_db'); // Substitua pelas credenciais do seu banco
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Processar o upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $video = $_FILES['video'];

    // Diretório para salvar os vídeos
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($video["name"]);

    // Mover o arquivo para o diretório
    if (move_uploaded_file($video["tmp_name"], $target_file)) {
        // Salvar no banco de dados
        $stmt = $conn->prepare("INSERT INTO videos (title, description, video_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $target_file);
        $stmt->execute();

        echo "Vídeo enviado com sucesso!";
        echo "<br><a href='training_videos.php'>Voltar</a>";
    } else {
        echo "Erro ao enviar o vídeo.";
    }
}

$conn->close();
?>
