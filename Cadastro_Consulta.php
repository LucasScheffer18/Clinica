<?php
    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexão com o banco de dados
        $conn = new mysqli("localhost", "root", "", "clinica");

        // Verifica se a conexão foi estabelecida com sucesso
        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        // Obtém os dados do formulário
        $data_consulta = $_POST["data_consulta"];
        $paciente_id = $_POST["paciente_id"];
        $medico_id = $_POST["medico_id"];

        // Prepara a consulta SQL para inserir os dados na tabela 'consultas'
        $sql = "INSERT INTO consultas (data_consulta, paciente_id, medico_id) VALUES ('$data_consulta', '$paciente_id', '$medico_id')";

        // Executa a consulta SQL
        if ($conn->query($sql) === TRUE) {
            echo "Consulta cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar a consulta: " . $conn->error;
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    }
?>

</body>
</html>

<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

    <form action="#" method="post">
        <h2>Cadastro de Consulta</h2>
        <!-- Campo consulta_id oculto -->
        <input type="hidden" id="consulta_id" name="consulta_id">

        <label for="data_consulta">Data da Consulta:</label>
        <input type="date" id="data_consulta" name="data_consulta" required>

        <label for="paciente_id">Paciente:</label>
        <select id="paciente_id" name="paciente_id" required>
            <option value="">Selecione o Paciente</option>
            <!-- Aqui você pode preencher com os nomes dos pacientes -->
        </select>

        <label for="medico_id">Médico:</label>
        <select id="medico_id" name="medico_id" required>
            <option value="">Selecione o Médico</option>
            <!-- Aqui você pode preencher com os nomes dos médicos -->
        </select>

        <input type="submit" value="Cadastrar">
    </form>
    <?php
        $conn = new mysqli("localhost", "root", "", "clinica");
    ?>
</body>
</html>
