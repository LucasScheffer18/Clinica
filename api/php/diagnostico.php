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
    <h2>Cadastro de Histórico</h2>
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

    <label for="data_diagnostico">Data do Diagnóstico:</label>
    <input type="date" id="data_diagnostico" name="data_diagnostico" required>

    <input type="submit" value="Cadastrar">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $diagnostico = $_POST['diagnostico'];
    $tratamento = $_POST['tratamento'];
    $prescricao = $_POST['prescricao'];
    $paciente_id = $_POST['paciente_id'];
    $medico_id = $_POST['medico_id'];
    $data_diagnostico = $_POST['data_diagnostico'];

    $data = [
        'diagnostico' => $diagnostico,
        'tratamento' => $tratamento,
        'prescricao' => $prescricao,
        'paciente_id' => $paciente_id,
        'medico_id' => $medico_id,
        'data_diagnostico' => $data_diagnostico
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents('http://node:3000/diagnostico', false, $context);

    if ($result === FALSE) {
        echo '<p>Erro ao cadastrar diagnóstico.</p>';
    } else {
        echo ("
            <script>
            alert('Diagnóstico cadastrado com sucesso');
            location.href = 'agenda.php';
            </script>");
    }
}
?>
