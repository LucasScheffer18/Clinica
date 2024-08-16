<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="login-container">
    <h2>Cadastro de Usuário</h2>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $data = array('email' => $email, 'senha' => $senha);
        $jsonData = json_encode($data);

        $ch = curl_init('http://login-container:3002/register');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo '<p class="error-message">Erro ao comunicar com o serviço de login: ' . curl_error($ch) . '</p>';
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode === 200) {
                echo '<p class="success-message">Usuário registrado com sucesso!</p>';
            } else {
                $responseData = json_decode($response, true);
                echo '<p class="error-message">Erro ao registrar usuário: ' . $responseData['message'] . '</p>';
            }
        }

        curl_close($ch);
    }
    ?>

    <form action="cadastro_usuario.php" method="post">
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu Email" required>
        </div>

        <div class="input-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" name="enviar">Registrar</button>
    </form>
</div>
</body>
</html>
