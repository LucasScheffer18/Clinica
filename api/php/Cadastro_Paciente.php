<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

<form method="post">
    <h2>Cadastro de Pacientes</h2>
    <input type="hidden" id="paciente_id" name="paciente_id">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="data_nascimento">Data de Nascimento:</label>
    <input type="date" id="data_nascimento" name="data_nascimento" required>

    <label for="endereco">Endereço:</label>
    <input type="text" id="endereco" name="endereco" required>

    <label for="telefone">Telefone:</label>
    <input type="tel" id="telefone" name="telefone" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" placeholder="(XX) XXXXX-XXXX" required>

    <input type="submit" name="enviar" value="Cadastrar">
</form>

<?php
if(isset($_POST["enviar"])){
    $nome = $_POST["nome"];
    $nasc = $_POST["data_nascimento"];
    $endereco = $_POST["endereco"];
    $telefone = $_POST["telefone"];

    $data = array(
        'nome' => $nome,
        'data_nascimento' => $nasc,
        'endereco' => $endereco,
        'telefone' => $telefone
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents('http://node:3000/pacientes', false, $context);

    if ($result === FALSE) {
        echo ("<script>alert('Erro ao cadastrar paciente');</script>");
    } else {
        echo ("
        <script>
        alert('Paciente criado com sucesso');
        location.href = 'agenda.php';
        </script>");
    }
}
?>

<script>
    window.onload = function() {
        var telefoneInput = document.getElementById('telefone');
        telefoneInput.addEventListener('input', function() {
            var telefone = telefoneInput.value;
            telefone = telefone.replace(/\D/g, '');
            var formattedTelefone = '(' + telefone.substring(0, 2) + ') ' + telefone.substring(2, 7) + '-' + telefone.substring(7, 11);
            telefoneInput.value = formattedTelefone;
        });
    };
</script>
</body>
</html>
