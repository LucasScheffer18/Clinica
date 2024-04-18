<?php
// Cria a conexão
$conn = mysqli_connect("localhost","root","","clinica");

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida!";
    // Agora você pode executar consultas SQL e interagir com o banco de dados aqui
}
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
                    }
                }
            }
            
        }
    }
?>