<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css"> <!-- CSS -->
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>
        <form action="register_process.php" method="POST">
            <label for="username">Usuário</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Tipo de Conta</label>
            <select id="role" name="role">
                <option value="user">Usuário</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Cadastrar</button>
        </form>
        <p>Já possui conta? <a href="index.php">Faça login</a>.</p>
    </div>
</body>
</html>
