<?php require_once("menu_login.php")?>
<link rel="stylesheet" href="style.css">

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
    <?php
        $conn = new mysqli("localhost", "root", "", "clinica");
    ?>
</body>
</html>
