<?php require_once("menu.php")?>
<!-- <link rel="stylesheet" href="style.css"> -->
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico do Paciente</title>
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
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            color: white;
        }
        tr:nth-child(even) {
            background-color:grey;
        }
        th {
            background-color:#007bff;
        }
    </style>
</head>
<body>
    <h1>Histórico do Paciente</h1>
    <?php

            $conn = new mysqli("localhost", "root", "", "clinica");
            if($conn){
                $sql = "SELECT nome ,diagnostico,data_historico FROM historico,pacientes where historico.pacientes_id = pacientes.paciente_id";
                $mostrar_pacientes = mysqli_query($conn,$sql);
                if(mysqli_num_rows($mostrar_pacientes) > 0){
                    $pacientes = mysqli_fetch_array($mostrar_pacientes);
                    
                    $nome = $pacientes['nome'];
                    $diagnostico = $pacientes['diagnostico'];
                    $data_hist = $pacientes['data_historico'];
                }else{header("location: agenda.php");}
            }else{echo("Falha na coneção");}
        // Verificar conexão
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Consulta SQL para obter o histórico do paciente
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Exibir os resultados em uma tabela
            echo '<table>';
            echo '<tr><th>Nome</th><th>Diagnostico</th><th>Data</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['diagnostico'] . '</td>';
                echo '<td>' . date('d/m/Y', strtotime($row['data_historico'])) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Nenhum histórico encontrado para este paciente.</p>';
        }
    $conn->close();
    ?>
</body>