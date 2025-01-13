<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css"> <!-- CSS -->
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login_process.php" method="POST">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>
        <p>Não possui conta? <a href="register.php">Cadastre-se</a>.</p>
    </div>
</body>
</html>
