<?php require_once("menu_login.php")?>
<link rel="stylesheet" href="style.css">

    <form action="#" method="post">
        <h2>Cadastro de Consulta</h2>
        <!-- Campo consulta_id oculto -->
        <input type="hidden" id="consulta_id" name="consulta_id">

        <label for="data_consulta">Data da Consulta:</label>
        <input type="date" id="data_consulta" name="data_consulta" required>

        <label for="paciente_id">Paciente:</label>
        <select id="paciente_id" name="paciente_id" required>
            <option value="">Selecione o Paciente</option>
            <!-- Aqui você pode preencher com os nomes dos pacientes -->
        </select>

        <label for="medico_id">Médico:</label>
        <select id="medico_id" name="medico_id" required>
            <option value="">Selecione o Médico</option>
            <!-- Aqui você pode preencher com os nomes dos médicos -->
        </select>

        <input type="submit" value="Cadastrar">
    </form>
    <?php
        $conn = new mysqli("localhost", "root", "", "clinica");
    ?>
</body>
</html>
