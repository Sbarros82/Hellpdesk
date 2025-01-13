<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Identifica o papel do usuário
$role = $_SESSION['role'] ?? 'user'; // Assume 'user' como padrão
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help! - Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        header {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            font-size: 1.5rem;
            margin: 0;
        }
        header .logout-btn {
            color: #fff;
            text-decoration: none;
            background: #ff4d4d;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }
        .container {
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-title {
            color: #007bff;
        }
    </style>
</head>
<body>
    <header>
        <h1>Help! Portal</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>

    <div class="container">
        <div class="row g-4">
            <!-- Funcionalidades disponíveis para todos os usuários -->
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Abrir Ticket">
                    <div class="card-body">
                        <h5 class="card-title">Abrir Ticket</h5>
                        <p class="card-text">Precisa de ajuda? Abra um ticket para o suporte resolver.</p>
                        <a href="new_ticket.php" class="btn btn-primary">Abrir Ticket</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Visualizar Tickets">
                    <div class="card-body">
                        <h5 class="card-title">Visualizar Tickets</h5>
                        <p class="card-text">Acompanhe o status dos seus tickets abertos.</p>
                        <a href="view_tickets.php" class="btn btn-primary">Visualizar Tickets</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Treinamentos">
                    <div class="card-body">
                        <h5 class="card-title">Treinamentos</h5>
                        <p class="card-text">Acesse vídeos e materiais de treinamento exclusivos.</p>
                        <a href="training_videos.php" class="btn btn-primary">Ir para Treinamentos</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Configurações de Perfil">
                    <div class="card-body">
                        <h5 class="card-title">Configurações de Perfil</h5>
                        <p class="card-text">Atualize suas informações e preferências.</p>
                        <a href="profile.php" class="btn btn-primary">Configurações de Perfil</a>
                    </div>
                </div>
            </div>

            <!-- Funcionalidades exclusivas para administradores -->
            <?php if ($role === 'admin'): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Gerenciar Tickets">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Tickets</h5>
                            <p class="card-text">Visualize e gerencie todos os tickets do sistema.</p>
                            <a href="admin_tickets.php" class="btn btn-danger">Gerenciar Tickets</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Gerenciar Treinamentos">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Treinamentos</h5>
                            <p class="card-text">Adicione ou remova vídeos e materiais do AVA.</p>
                            <a href="admin_training.php" class="btn btn-danger">Gerenciar Treinamentos</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
