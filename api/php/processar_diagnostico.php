<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
require_once("menu.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valida e sanitiza os dados recebidos do formulário
    $consulta_id = filter_input(INPUT_POST, 'consulta_id', FILTER_SANITIZE_NUMBER_INT);
    $paciente_id = filter_input(INPUT_POST, 'paciente_id', FILTER_SANITIZE_NUMBER_INT);
    $medico_id = filter_input(INPUT_POST, 'medico_id', FILTER_SANITIZE_NUMBER_INT);
    $diagnostico = filter_input(INPUT_POST, 'diagnostico', FILTER_SANITIZE_STRING);
    $tratamento = filter_input(INPUT_POST, 'tratamento', FILTER_SANITIZE_STRING);
    $prescricao = filter_input(INPUT_POST, 'prescricao', FILTER_SANITIZE_STRING);
    $data_diagnostico = filter_input(INPUT_POST, 'data_diagnostico', FILTER_SANITIZE_STRING);

    // Verifica se todos os campos foram preenchidos
    if ($consulta_id && $paciente_id && $medico_id && $diagnostico && $tratamento && $prescricao && $data_diagnostico) {
        // Monta o array de dados a ser enviado para a API
        $data = [
            'consulta_id' => $consulta_id,
            'paciente_id' => $paciente_id,
            'medico_id' => $medico_id,
            'diagnostico' => $diagnostico,
            'tratamento' => $tratamento,
            'prescricao' => $prescricao,
            'data_diagnostico' => $data_diagnostico,
        ];

        // Converte o array para JSON
        $jsonData = json_encode($data);

        // Inicializa o cURL
        $ch = curl_init('http://node-container:3000/diagnostico');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        // Executa a requisição e captura a resposta
        $response = curl_exec($ch);

        // Verifica se houve erro no cURL
        if ($response === false) {
            echo "<script>alert('Erro ao conectar com a API'); window.location.href='index.php';</script>";
            curl_close($ch);
            exit;
        }

        // Fecha a conexão cURL
        curl_close($ch);

        // Converte a resposta de JSON para array
        $responseArray = json_decode($response, true);

        // Verifica se a resposta indica sucesso
        if (isset($responseArray['success']) && $responseArray['success']) {
            echo "<script>alert('Diagnóstico cadastrado com sucesso'); window.location.href='agenda.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar o diagnóstico: " . htmlspecialchars($responseArray['message']) . "'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href='agenda.php';</script>";
    }
}
?>
