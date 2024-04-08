<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Histórico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        input[type="text"], input[type="date"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <form action="#" method="post">
        <h2>Cadastro de Histórico</h2>
        <!-- Campo historico_id oculto -->
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
            <!-- Aqui você pode preencher com os nomes dos pacientes -->
        </select>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
