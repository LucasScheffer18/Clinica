<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

<form action="#" method="post">
    <h2>Cadastro de Médico</h2>
    <input type="hidden" id="medico_id" name="medico_id">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="especialidade">Especialidade:</label>
    <input type="text" id="especialidade" name="especialidade" required>

    <input type="submit" name="enviar" value="Cadastrar">
</form>

<?php
if(isset($_POST['enviar'])){
    $nome = $_POST["nome"];
    $especialidade = $_POST["especialidade"];
    
    $data = array(
        'nome' => $nome,
        'especialidade' => $especialidade
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents('http://node:3000/medicos', false, $context);

    if ($result === FALSE) {
        echo ("<script>alert('Erro ao cadastrar médico');</script>");
    } else {
        echo ("
        <script>
        alert('Médico criado com sucesso');
        location.href = 'menu.php';
        </script>");
    }
}
?>
</body>
</html>
