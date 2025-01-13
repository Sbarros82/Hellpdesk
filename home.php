<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Corporativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: #fff;
            padding: 1.5rem 1rem;
            text-align: center;
            position: relative;
        }
        header h1 {
            font-size: 3rem;
            margin: 0;
        }
        .auth-buttons {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
        }
        .auth-buttons .btn {
            margin-left: 0.5rem;
        }
        .hero {
            text-align: center;
            padding: 4rem 1rem;
            background-color: #f4f8fc;
        }
        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            padding: 3rem 1rem;
            background-color: #fff;
        }
        .feature {
            text-align: center;
            max-width: 300px;
        }
        .feature img {
            width: 100%;
            height: auto;
        }
        .feature h3 {
            margin-top: 1rem;
            color: #007bff;
        }
        .contact-form {
            padding: 3rem 1rem;
            background: #f4f8fc;
            text-align: center;
        }
        .contact-form h2 {
            margin-bottom: 1.5rem;
        }
        .contact-form form {
            max-width: 500px;
            margin: 0 auto;
        }
        footer {
            background-color: #333;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1> Portal Corporativo</h1>
        <div class="auth-buttons">
            <a href="index.php" class="btn btn-outline-light">Login</a>
            <a href="register.php" class="btn btn-light">Registrar</a>
        </div>
    </header>

    <section class="hero">
        <h2>Bem-vindo!</h2>
        <p>O portal que revoluciona a gestão corporativa, trazendo eficiência e modernidade para sua empresa.</p>
    </section>

    <section class="features">
        <div class="feature">
            <img src="https://via.placeholder.com/300x200" alt="Feature 1">
            <h3>Gestão Simplificada</h3>
            <p>Organize suas operações de forma prática e intuitiva.</p>
        </div>
        <div class="feature">
            <img src="https://via.placeholder.com/300x200" alt="Feature 2">
            <h3>Segurança de Dados</h3>
            <p>Seus dados protegidos com as melhores práticas do mercado.</p>
        </div>
        <div class="feature">
            <img src="https://via.placeholder.com/300x200" alt="Feature 3">
            <h3>Suporte 24/7</h3>
            <p>Conte com nossa equipe sempre que precisar.</p>
        </div>
    </section>

    <section class="contact-form">
        <h2>Fale Conosco</h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Seu Nome</label>
                <input type="text" class="form-control" id="name" placeholder="Digite seu nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Seu E-mail</label>
                <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Mensagem</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Digite sua mensagem" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 Help! Portal Corporativo. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
