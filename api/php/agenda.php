<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
require_once("menu.php");

// Verifica se o formulário de exclusão foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consulta_id'])) {
    $consultaId = $_POST['consulta_id'];

    // Faz a requisição DELETE para o backend Node.js
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://node-container:3000/consultas/$consultaId");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Processa a resposta
    $result = json_decode($response, true);
    if (isset($result['message']) && $result['message'] === 'Consulta excluída com sucesso') {
        echo "<script>alert('Consulta excluída com sucesso'); window.location.reload();</script>";
        //exit; // Certifique-se de que o script PHP para aqui
    }
}

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
    <title>Consultas Agendadas</title>
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
        tr {
            background-color: #000;
            color: white;
        }
        tbody tr:nth-child(even) {
            background-color: #F8F8FF;
            color: black;
        }
        tbody tr:nth-child(odd) {
            background-color: #808080;
            color: white;
        }
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

        /* Estilos do modal */
        .modal {
            display: none; /* Oculto por padrão */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            position: relative; /* Adicionado para que o botão de fechar seja posicionado relativo ao modal */
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($consultas)) {
                foreach ($consultas as $consulta) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($consulta['consulta_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($consulta['paciente_nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($consulta['medico_nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($consulta['data_consulta']) . "</td>";
                    echo "<td>";
                    echo "<button class='openModalBtn' data-consulta-id='" . htmlspecialchars($consulta['consulta_id']) . "' data-paciente-id='" . htmlspecialchars($consulta['paciente_id']) . "' data-medico-id='" . htmlspecialchars($consulta['medico_id']) . "'>Diagnóstico</button>";
                    echo "<form method='POST' style='display:inline-block;'>";
                    echo "<input type='hidden' name='consulta_id' value='" . htmlspecialchars($consulta['consulta_id']) . "'>";
                    echo "<button type='submit'>Excluir</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="5">Nenhuma consulta encontrada.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    <!-- O Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Cadastro de Diagnóstico</h2>
            <form id="DiagnosticoForm" method="POST" action="processar_diagnostico.php">
                <input type="hidden" id="consulta_id" name="consulta_id">
                <input type="hidden" id="paciente_id" name="paciente_id">
                <input type="hidden" id="medico_id" name="medico_id">

                <label for="diagnostico">Diagnóstico:</label>
                <input type="text" id="diagnostico" name="diagnostico" required>

                <label for="tratamento">Tratamento:</label>
                <input type="text" id="tratamento" name="tratamento" required>

                <label for="prescricao">Prescrição:</label>
                <input type="text" id="prescricao" name="prescricao" required>

                <label for="data_diagnostico">Data do Diagnóstico:</label>
                <input type="date" id="data_diagnostico" name="data_diagnostico" required>

                <input type="submit" value="Cadastrar Diagnóstico">
            </form>
        </div>
    </div>
    <script>
        // Abre o modal e preenche os campos
        document.querySelectorAll('.openModalBtn').forEach(button => {
            button.onclick = function() {
                document.getElementById('consulta_id').value = this.dataset.consultaId;
                document.getElementById('paciente_id').value = this.dataset.pacienteId;
                document.getElementById('medico_id').value = this.dataset.medicoId;

                document.getElementById('myModal').style.display = 'block';
            }
        });

        // Fecha o modal
        document.querySelector('.close').onclick = function() {
            document.getElementById('myModal').style.display = 'none';
        }

        // Fecha o modal ao clicar fora dele
        window.onclick = function(event) {
            if (event.target === document.getElementById('myModal')) {
                document.getElementById('myModal').style.display = 'none';
            }
        }
    </script>
</body>
</html>
