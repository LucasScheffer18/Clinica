<?php require_once("menu.php")?>
<link rel="stylesheet" href="style.css">

    <form action="#" method="post">
        <h2>Cadastro de Médico</h2>
        <input type="hidden" id="medico_id" name="medico_id">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="especialidade">Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade" required>

        <input type="submit" value="Cadastrar">
    </form>
    <?php
        $conn = new mysqli("localhost", "root", "", "clinica");
    ?>
</body>
</html>
