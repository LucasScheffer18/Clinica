<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

<form method="post">
    <h2>Cadastro de Pacientes</h2>
    <!-- Campo paciente_id oculto -->
    <input type="hidden" id="paciente_id" name="paciente_id">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="data_nascimento">Data de Nascimento:</label>
    <input type="date" id="data_nascimento" name="data_nascimento" required>

    <label for="endereco">Endereço:</label>
    <input type="text" id="endereco" name="endereco" required>

    <label for="telefone">Telefone:</label>
    <input type="tel" id="telefone" name="telefone" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" placeholder="(XX) XXXXX-XXXX" required>

    <input type="submit" name="enviar" value="Cadastrar">
</form>

<?php
    $conn = new mysqli("localhost", "root", "", "clinica");
    if(isset($_POST["enviar"])){
            $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
            $nasc =mysqli_real_escape_string($conn,  $_POST["data_nascimento"]);
            $endereco =mysqli_real_escape_string($conn,  $_POST["endereco"]);
            $telefone = mysqli_real_escape_string($conn, $_POST["telefone"]);


            if($conn){
                $sql = "INSERT INTO pacientes(nome, data_nasc, endereco, telefone) VALUES ('$nome','$nasc','$endereco', '$telefone')";
                if(mysqli_query($conn, $sql)){
                    echo ("
                    <script>
                    alert('Cliente criado com sucesso');
                    location.href = 'menu.php';
                    </script>");
                }
            }

    }
    mysqli_close($conn);
    ?>

<script>
    // Adicionando máscara ao campo de telefone
    window.onload = function() {
        var telefoneInput = document.getElementById('telefone');
        telefoneInput.addEventListener('input', function() {
            var telefone = telefoneInput.value;
            telefone = telefone.replace(/\D/g, ''); // Remove caracteres não numéricos
            var formattedTelefone = '(' + telefone.substring(0, 2) + ') ' + telefone.substring(2, 7) + '-' + telefone.substring(7, 11);
            telefoneInput.value = formattedTelefone;
        });
    };
</script>
