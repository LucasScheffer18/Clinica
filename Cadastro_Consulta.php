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

<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

<form action="#" method="post">
    <h2>Cadastro de Consulta</h2>
    <!-- Campo consulta_id oculto -->
    <input type="hidden" id="consulta_id" name="consulta_id">

    <label for="data_consulta">Data da Consulta:</label>
    <input type="datetime-local" id="data_consulta" name="data_consulta" required>

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

    <input type="submit" name="enviar" value="Cadastrar">

    <?php
     if(isset($_POST['enviar'])){
        $data_consulta = mysqli_real_escape_string($conn, $_POST["data_consulta"]);
        $paciente_id = mysqli_real_escape_string($conn, $_POST["paciente_id"]);
        $medico_id = mysqli_real_escape_string($conn, $_POST["medico_id"]);
        
        if($conn){

            $sql = "INSERT INTO consultas(data_consulta,pacientes_id,medicos_id) VALUES ('$data_consulta','$paciente_id','$medico_id')";
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
</form>