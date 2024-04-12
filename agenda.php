<?php require_once("menu.php");
// Consulta SQL para obter as consultas da semana atual
$data_inicio = date('Y-m-d', strtotime('monday this week'));
$data_fim = date('Y-m-d', strtotime('sunday this week'));

$conn = mysqli_connect("localhost","root","","clinica");

$sql = "SELECT * FROM consultas WHERE data_consulta BETWEEN '$data_inicio' AND '$data_fim'";
$resultado = $conn->query($sql);

// Array para armazenar as consultas
$consultas = array();
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $consultas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="style.css">
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
            height: 100vh;
            flex-direction: column; /* Centraliza verticalmente */
        }
        table {
            width: 80%; /* Defina o tamanho da tabela conforme necessário */
            border-collapse: collapse;
            margin-top: 20px; /* Adiciona um espaço entre o título e a tabela */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .titulo {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="titulo">
        <h3>Agenda Semanal de Consultas</h3>
    </div>
    <table>
        <tr>
            <th>Hora</th>
            <?php
            // Crie cabeçalhos para cada dia da semana
            $dias_semana = array('Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo');
            foreach ($dias_semana as $dia) {
                echo "<th>$dia</th>";
            }
            ?>
        </tr>

        <?php
        // Exibir as consultas processadas
        $horas_dia = range(8, 16); // Horário de funcionamento da clínica (por exemplo, 8h às 16h)
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
                        echo "<td></td>"; // Espaço em branco se não houver consulta agendada
                    }
                }
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>
</html>
