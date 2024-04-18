<<<<<<< HEAD
<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

    <form action="#" method="post">
        <h2>Cadastro de Médico</h2>
        <input type="hidden" id="medico_id" name="medico_id">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="especialidade">Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade" required>

        <input type="submit" name="enviar" value="Cadastrar">
    </form>
    <?php
        $conn = new mysqli("localhost", "root", "", "clinica");
        if(isset($_POST['enviar'])){
            $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
            $especialidade = mysqli_real_escape_string($conn, $_POST["especialidade"]);
            
            if($conn){

                $sql = "INSERT INTO medicos(nome,especialidade) VALUES ('$nome','$especialidade')";
                if(mysqli_query($conn,$sql)){
                    echo ("
                    <script>
                    alert('Medico criado com sucesso');
                    location.href = 'menu.php';
                    </script>");
                }
            }
    
        }
    ?>
</body>
</html>
=======
<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

    <form action="#" method="post">
        <h2>Cadastro de Médico</h2>
        <input type="hidden" id="medico_id" name="medico_id">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="especialidade">Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade" required>

        <input type="submit" name="enviar" value="Cadastrar">
    </form>
    <?php
        $conn = new mysqli("localhost", "root", "", "clinica");
        if(isset($_POST['enviar'])){
            $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
            $especialidade = mysqli_real_escape_string($conn, $_POST["especialidade"]);
            
            if($conn){

                $sql = "INSERT INTO medicos(nome,especialidade) VALUES ('$nome','$especialidade')";
                if(mysqli_query($conn,$sql)){
                    echo ("
                    <script>
                    alert('Medico criado com sucesso');
                    location.href = 'menu.php';
                    </script>");
                }
            }
    
        }
    ?>
</body>
</html>
>>>>>>> 58fe7203e6d775111bc7f0e47ac0995fb9245a7d
