<?php require_once("menu.php") ?>
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
    </style>
</head>

<body>
    <h1>Histórico do Paciente</h1>

    <table id="historico-table" border="1">
        <thead>
            <tr>
                <th>Nome do Paciente</th>
                <th>Diagnóstico</th>
                <th>Data do Histórico</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os dados serão inseridos aqui -->
        </tbody>
    </table>

    <script>
		document.addEventListener('DOMContentLoaded', function() {
			fetch('http://localhost:3000/historico')
				.then(response => response.json())
				.then(data => {
					const tableBody = document.getElementById('historico-table').getElementsByTagName('tbody')[0];

					data.forEach(record => {
						const row = tableBody.insertRow();

						const cellNome = row.insertCell(0);
						const cellDiagnostico = row.insertCell(1);
						const cellDataHistorico = row.insertCell(2);

						cellNome.textContent = record.nome;
						cellDiagnostico.textContent = record.diagnostico;
						cellDataHistorico.textContent = record.data_historico;
					});
				})
				.catch(error => console.error('Erro ao carregar dados:', error));
		});
	</script>

</body>

</html>
