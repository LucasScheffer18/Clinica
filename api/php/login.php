<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $data = array('email' => $email, 'senha' => $senha);
    $jsonData = json_encode($data);

    $ch = curl_init('http://login-container:3002/login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['message']) && $responseData['message'] === 'Login bem-sucedido') {
        header("Location: agenda.php");
        exit();
    } else {
        $errorMessage = "Email ou senha inválidos";
    }
}
?>
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
    if (isset($errorMessage)) {
        echo '<p class="error-message">' . $errorMessage . '</p>';
    }
    ?>
    
    <form action="login.php" method="post">
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Digite seu Email" required>
        </div>

        <div class="input-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" name="enviar">Entrar</button>
    </form>
</div>
</body>
</html>
