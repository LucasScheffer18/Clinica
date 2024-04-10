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
    
    <form action="" method="post">
        <div class="input-group">
            <label for="text">Email:</label>
            <input type="text" id="email" name="email" placeholder="Digite seu Email" required>
        </div>

        <div class="input-group">
            <label for="password">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" name="enviar">Entrar</button>
        <?php
            // Cria a conexão
            $conn = mysqli_connect("localhost","root","","clinica");

            // Verifica a conexão
            if(isset($_POST['enviar']) == true){
                // Verifica se os campos foram enviados via POST
                $sql = "SELECT email, senha FROM medicos";
                $email =mysqli_real_escape_string($conn,  $_POST['email']);
                $senha =mysqli_real_escape_string($conn,  $_POST['senha']);


                if($conn){
                    $registros = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($registros) > 0){
                        while ($registro = mysqli_fetch_array($registros) ){
                            if($registro['email'] == $email){
                                $email_valido = true;
                                if($registro['senha'] == $senha){
                                
                                    header("Location: menu.php");
                                }else{
                                    echo("<script>alert('Email ou senha Invalida');</script>");

                                }
                            }else{
                                echo("<script>alert('Email ou senha Invalida');</script>");
                            }
                        }
                        
                    }
                }
            }
        ?>
        
    </form>
</div>

</body>
</html>
