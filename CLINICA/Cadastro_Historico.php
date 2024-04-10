<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Histórico</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
