<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

<?php
    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "clinica");

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Consulta SQL para obter os pacientes
    $sql_pacientes = "SELECT paciente_id, nome FROM pacientes";
    $result_pacientes = $conn->query($sql_pacientes);

     // Consulta SQL para obter os médicos
     $sql_medicos = "SELECT medico_id, nome FROM medicos";
     $result_medicos = $conn->query($sql_medicos);
?>

    <form action="#" method="post">
        <h2>Cadastro de Histórico</h2>
        <!-- Campo historico_id oculto -->
        <input type="hidden" id="historico_id" name="historico_id">

        <label for="diagnostico">Diagnóstico:</label>
        <input type="text" id="diagnostico" name="diagnostico" required>

        <label for="tratamento">Tratamento:</label>
        <input type="text" id="tratamento" name="tratamento" required>

        <label for="prescricao">Prescrição:</label>
        <input type="text" id="prescricao" name="prescricao" required>

        <label for="paciente_id">Paciente:</label>
        <select id="paciente_id" name="paciente_id" required>
            <option value="">Selecione o Paciente</option>
            <?php
            // Preenche as opções do select com os nomes dos pacientes
            if ($result_pacientes->num_rows > 0) {
                while ($row = $result_pacientes->fetch_assoc()) {
                    echo "<option value='" . $row['paciente_id'] . "'>" . $row['nome'] . "</option>";
                }
            }
        ?>
        </select>

        <label for="medico_id">Médico:</label>
        <select id="medico_id" name="medico_id" required>
        <option value="">Selecione o Médico</option>
        <?php
            // Preenche as opções do select com os nomes dos médicos
            if ($result_medicos->num_rows > 0) {
                while ($row = $result_medicos->fetch_assoc()) {
                    echo "<option value='" . $row['medico_id'] . "'>" . $row['nome'] . "</option>";
                }
            }
        ?>
    </select>

        <label for="data_consulta">Data da Consulta:</label>
        <input type="date" id="data_diagnostico" name="data_diagnostico" required>

        <input type="submit" name='enviar' value="Cadastrar">
    </form>
    <?php
     if(isset($_POST['enviar'])){
        $diagnostico = mysqli_real_escape_string($conn, $_POST["diagnostico"]);
        $tratamento = mysqli_real_escape_string($conn, $_POST["tratamento"]);
        $prescricao = mysqli_real_escape_string($conn, $_POST["prescricao"]);
        $paciente_id = mysqli_real_escape_string($conn , $_POST["paciente_id"]);
        $medico_id = mysqli_real_escape_string($conn, $_POST["medico_id"]);
        $data_diagnostico = mysqli_real_escape_string($conn, $_POST["data_diagnostico"]);
        
        if($conn){

            $sql = "INSERT INTO historico(diagnostico,tratamento,prescricao,medico_id,pacientes_id,data_historico) VALUES ('$diagnostico','$tratamento','$prescricao','$medico_id','$paciente_id','$data_diagnostico')";
            if(mysqli_query($conn,$sql)){
                echo ("
                <script>
                alert('Medico criado com sucesso');
                location.href = 'agenda.php';
                </script>");
            }
        }

    }

    ?> 
</body>
</html>
