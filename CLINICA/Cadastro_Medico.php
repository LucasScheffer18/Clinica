<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Médico</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="#" method="post">
        <h2>Cadastro de Médico</h2>
        <input type="hidden" id="medico_id" name="medico_id">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="especialidade">Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade" required>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
