<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<?php require_once("menu.php");

// Obtém as datas de início e fim da semana atual
$data_inicio = date('Y-m-d', strtotime('monday this week'));
$data_fim = date('Y-m-d', strtotime('sunday this week'));

// Faz a requisição para o backend Node.js
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://node-container:3000/consultas?data_inicio=$data_inicio&data_fim=$data_fim");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$consultas = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: block;
            margin-top: 150px;
        }
        h1 {
            text-align: center;
            color: white;
        }
        table {
            width: 96.5%;
            border-collapse: collapse;
            margin-left: 30px;
            margin-top: 30px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }
        tr{
            background-color: #000;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #F8F8FF;
            color: black;
        }
        
        /* Linhas ímpares */
       tbody tr:nth-child(odd) {
            background-color: #808080;
            color: white;
        }

        /* Responsividade */
        @media (max-width: 600px) {

            table, th, td {
                display: block;
            }

            th, td {
                width: 100%;
                box-sizing: border-box;
            }

            td {
                position: relative;
                padding-left: 50%;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 45%;
                padding-left: 10px;
                white-space: nowrap;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <h1>Consultas Agendadas</h1>
    <table>
        <thead>
            <tr>
                <th>ID da Consulta</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // URL da API
            $url = "http://node-container:3000/consultas"; // Substitua pelo endereço correto

            // Inicializa o cURL
            $ch = curl_init();

            // Configurações do cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPGET, true);

            // Executa a requisição e armazena a resposta
            $response = curl_exec($ch);

            // Verifica se houve erro
            if (curl_errno($ch)) {
                echo '<tr><td colspan="4">Erro ao se conectar à API: ' . curl_error($ch) . '</td></tr>';
                curl_close($ch);
                exit;
            }

            // Fecha a conexão cURL
            curl_close($ch);

            // Decodifica a resposta JSON
            $consultas = json_decode($response, true);

            // Verifica se o retorno não está vazio
            if (!empty($consultas)) {
                foreach ($consultas as $consulta) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($consulta['consulta_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($consulta['paciente_nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($consulta['medico_nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($consulta['data_consulta']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="4">Nenhuma consulta encontrada.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>