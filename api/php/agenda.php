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
        /* Adicione estilos conforme necessário */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 110vh;
            flex-direction: column;
            overflow:hidden;
            margin-top: 15px;
        }
        table {
            width: 80%; /* Defina o tamanho da tabela conforme necessário */
            border-collapse: collapse;
            background-color: #f4f4f4;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            width: 100px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Hora</th>
            <?php
            // Crie cabeçalhos para cada dia da semana
            $dias_semana = array('Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta');
            foreach ($dias_semana as $dia) {
                echo "<th>$dia</th>";
            }
            ?>
        </tr>

        <?php
        // Exibir as consultas processadas
        $horas_dia = range(9, 18); // Horário de funcionamento da clínica (por exemplo, 8h às 16h)
        foreach ($horas_dia as $hora) {
            for ($minuto = 0; $minuto < 60; $minuto += 30) {
                $hora_formatada = str_pad($hora, 2, '0', STR_PAD_LEFT); // Adiciona um zero à esquerda, se necessário
                $minuto_formatado = str_pad($minuto, 2, '0', STR_PAD_LEFT); // Adiciona um zero à esquerda, se necessário
                $hora_completa = "$hora_formatada:$minuto_formatado";
                echo "<tr>";
                echo "<td>$hora_completa</td>";

                // Loop para cada dia da semana
                foreach ($dias_semana as $dia) {
                    // Verifique se há uma consulta para esta hora e dia
                    $consulta_encontrada = false;
                    foreach ($consultas as $consulta) {
                        if (date('l', strtotime($consulta['data_consulta'])) == $dia && date('H:i', strtotime($consulta['hora_consulta'])) == $hora_completa) {
                            // Consulta encontrada para esta hora e dia
                            $consulta_encontrada = true;
                            echo "<td>{$consulta['nome_paciente']} - {$consulta['nome_medico']}</td>";
                            break;
                        }
                    }
                    if (!$consulta_encontrada) {
                        echo "<td></td>";
                    }
                }
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>
</html>
