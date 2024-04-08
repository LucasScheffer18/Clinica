<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Consultório Médico</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <h2>Bem-vindo ao Consultório Médico</h2>
    
    <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo '<p class="error-message">Usuário ou senha incorretos. Tente novamente.</p>';
    }
    ?>
    
    <form action="process_login.php" method="post">
        <div class="input-group">
            <label for="username">Email:</label>
            <input type="text" id="email" name="email" placeholder="Digite seu Email" required>
        </div>

        <div class="input-group">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" name="enviar">Entrar</button>
        
    </form>
</div>

</body>
</html>
