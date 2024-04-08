<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pacientes</title>
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
        <h2>Cadastro de Pacientes</h2>
        <!-- Campo paciente_id oculto -->
        <input type="hidden" id="paciente_id" name="paciente_id">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" placeholder="(XX) XXXXX-XXXX" required>

        <input type="submit" value="Cadastrar">
    </form>

    <script>
        // Adicionando máscara ao campo de telefone
        window.onload = function() {
            var telefoneInput = document.getElementById('telefone');
            telefoneInput.addEventListener('input', function() {
                var telefone = telefoneInput.value;
                telefone = telefone.replace(/\D/g, ''); // Remove caracteres não numéricos
                var formattedTelefone = '(' + telefone.substring(0, 2) + ') ' + telefone.substring(2, 7) + '-' + telefone.substring(7, 11);
                telefoneInput.value = formattedTelefone;
            });
        };
    </script>
</body>
</html>
