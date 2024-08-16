<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<?php
// Função para enviar requisição ao backend Node.js
function enviarParaBackend($url, $data = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($data) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Requisição ao backend Node.js para obter pacientes
$pacientes_url = 'http://node:3000/pacientes';
$pacientes_response = enviarParaBackend($pacientes_url);

$pacientes = $pacientes_response['pacientes'] ?? array();

// Requisição ao backend Node.js para obter médicos
$medicos_url = 'http://node:3000/medicos';
$medicos_response = enviarParaBackend($medicos_url);

$medicos = $medicos_response['medicos'] ?? array();
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
            foreach ($pacientes as $paciente) {
                echo "<option value='" . $paciente['paciente_id'] . "'>" . $paciente['nome'] . "</option>";
            }
        ?>
    </select>

    <label for="medico_id">Médico:</label>
    <select id="medico_id" name="medico_id" required>
        <option value="">Selecione o Médico</option>
        <?php
            // Preenche as opções do select com os nomes dos médicos
            foreach ($medicos as $medico) {
                echo "<option value='" . $medico['medico_id'] . "'>" . $medico['nome'] . "</option>";
            }
        ?>
    </select>

    <input type="submit" name="enviar" value="Cadastrar">

    <?php
    if (isset($_POST['enviar'])) {
        $data_consulta = $_POST["data_consulta"];
        $paciente_id = $_POST["paciente_id"];
        $medico_id = $_POST["medico_id"];

        $consulta_data = array(
            'data_consulta' => $data_consulta,
            'paciente_id' => $paciente_id,
            'medico_id' => $medico_id
        );

        $consulta_url = 'http://node:3000/consultas';
        $consulta_response = enviarParaBackend($consulta_url, $consulta_data);

        if (isset($consulta_response['success']) && $consulta_response['success'] === true) {
            echo ("
            <script>
            alert('Consulta cadastrada com sucesso');
            location.href = 'agenda.php';
            </script>");
        } else {
            echo ("
            <script>
            alert('Erro ao cadastrar consulta');
            </script>");
        }
    }
    ?>
</form>
