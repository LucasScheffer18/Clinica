const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
app.use(bodyParser.json());
app.use(cors());

const db = mysql.createConnection({
    host: 'db', // Nome do serviço do banco de dados no Docker Compose
    user: 'root',
    password: 'clinicadb',
    database: 'clinica'
});

db.connect((err) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados:', err);
    } else {
        console.log('Conectado ao banco de dados.');
    }
});

app.post('/login', (req, res) => {
    const { email, senha } = req.body;
    console.log('Login request received:', email);

    const sql = 'SELECT email, senha FROM usuario WHERE email = ?';
    db.query(sql, [email], (err, results) => {
        if (err) {
            console.error('Erro ao executar a consulta:', err);
            return res.status(500).json({ error: 'Erro ao executar a consulta' });
        }

        console.log('Login query results:', results);

        if (results.length > 0) {
            const user = results[0];
            if (user.senha === senha) {
                res.status(200).json({ success: true, message: 'Login bem-sucedido' });
            } else {
                res.status(401).json({ error: 'Senha incorreta' });
            }
        } else {
            res.status(404).json({ error: 'Usuário não encontrado' });
        }
    });
});


app.get('/consultas', (req, res) => {
    const data_inicio = req.query.data_inicio;
    const data_fim = req.query.data_fim;
    console.log('Consultas request received:', data_inicio, data_fim);

    const sql = 'SELECT pacientes_id, data_consulta FROM consultas WHERE data_consulta BETWEEN ? AND ?';
    db.query(sql, [data_inicio, data_fim], (err, results) => {
        if (err) {
            console.error('Erro ao executar a consulta:', err);
            return res.status(500).json({ error: 'Erro ao executar a consulta' });
        }
        console.log('Consultas query results:', results);
        res.status(200).json(results);
    });
});


// Obter pacientes
app.get('/pacientes', (req, res) => {
    console.log('Request to get patients received');
    const sql = 'SELECT paciente_id, nome FROM pacientes';
    db.query(sql, (err, results) => {
        if (err) {
            console.error('Erro ao obter pacientes:', err);
            return res.status(500).json({ error: 'Erro ao obter pacientes' });
        }
        console.log('Patients query results:', results);
        res.status(200).json({ pacientes: results });
    });
});


// Obter médicos
app.get('/medicos', (req, res) => {
    console.log('Request to get doctors received');
    const sql = 'SELECT medico_id, nome FROM medicos';
    db.query(sql, (err, results) => {
        if (err) {
            console.error('Erro ao obter médicos:', err);
            return res.status(500).json({ error: 'Erro ao obter médicos' });
        }
        console.log('Doctors query results:', results);
        res.status(200).json({ medicos: results });
    });
});


// Cadastrar consulta
app.post('/consultas', (req, res) => {
    const { data_consulta, paciente_id, medico_id } = req.body;
    console.log('Request to add consultation received:', data_consulta, paciente_id, medico_id);

    const sql = 'INSERT INTO consultas (data_consulta, pacientes_id, medicos_id) VALUES (?, ?, ?)';
    db.query(sql, [data_consulta, paciente_id, medico_id], (err, result) => {
        if (err) {
            console.error('Erro ao cadastrar consulta:', err);
            return res.status(500).json({ error: 'Erro ao cadastrar consulta' });
        }
        console.log('Consultation added successfully:', result);
        res.status(200).json({ success: true });
    });
});


// Cadastrar médico
app.post('/medicos', (req, res) => {
    const { nome, especialidade } = req.body;
    console.log('Request to add doctor received:', nome, especialidade);

    const sql = 'INSERT INTO medicos (nome, especialidade) VALUES (?, ?)';
    db.query(sql, [nome, especialidade], (err, result) => {
        if (err) {
            console.error('Erro ao cadastrar médico:', err);
            return res.status(500).json({ error: 'Erro ao cadastrar médico' });
        }
        console.log('Doctor added successfully:', result);
        res.status(200).json({ success: true });
    });
});


// Cadastrar paciente
app.post('/pacientes', (req, res) => {
    const { nome, data_nascimento, endereco, telefone } = req.body;
    console.log('Request to add patient received:', nome, data_nascimento, endereco, telefone);

    const sql = 'INSERT INTO pacientes (nome, data_nasc, endereco, telefone) VALUES (?, ?, ?, ?)';
    db.query(sql, [nome, data_nascimento, endereco, telefone], (err, result) => {
        if (err) {
            console.error('Erro ao cadastrar paciente:', err);
            return res.status(500).json({ error: 'Erro ao cadastrar paciente' });
        }
        console.log('Patient added successfully:', result);
        res.status(200).json({ success: true });
    });
});


// Cadastrar histórico
app.post('/historico', (req, res) => {
    const { diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico } = req.body;
    console.log('Request to add historical record received:', diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico);

    const sql = 'INSERT INTO historico (diagnostico, tratamento, prescricao, paciente_id, medico_id, data_historico) VALUES (?, ?, ?, ?, ?, ?)';
    db.query(sql, [diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico], (err, result) => {
        if (err) {
            console.error('Erro ao cadastrar histórico:', err);
            return res.status(500).json({ error: 'Erro ao cadastrar histórico' });
        }
        console.log('Historical record added successfully:', result);
        res.status(200).json({ success: true });
    });
});


// Obter histórico de diagnósticos
app.get('/historico', (req, res) => {
    console.log('Request to get historical records received');
    const sql = `SELECT nome ,diagnostico,data_historico FROM historico,pacientes where historico.paciente_id = pacientes.paciente_id`;
    db.query(sql, (err, results) => {
        if (err) {
            console.error('Erro ao obter histórico de diagnósticos:', err);
            return res.status(500).json({ error: 'Erro ao obter histórico de diagnósticos' });
        }
        console.log('Historical records query results:', results);
        res.status(200).json(results);
    });
});



// Adicionar diagnóstico
app.post('/diagnostico', (req, res) => {
    const { diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico } = req.body;
    console.log('Request to add diagnosis received:', diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico);

    const sql = `
        INSERT INTO historico (diagnostico, tratamento, prescricao, paciente_id, medico_id, data_historico)
        VALUES (?, ?, ?, ?, ?, ?)
    `;
    db.query(sql, [diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico], (err, result) => {
        if (err) {
            console.error('Erro ao adicionar diagnóstico:', err);
            return res.status(500).json({ error: 'Erro ao adicionar diagnóstico' });
        }
        console.log('Diagnosis added successfully:', result);
        res.status(200).json({ success: true });
    });
});

app.post('/register', (req, res) => {
  const { email, senha } = req.body;

  if (!email || !senha) {
    return res.status(400).json({ error: 'Email e senha são obrigatórios' });
  }

  // Criptografa a senha
  bcrypt.hash(senha, 10, (err, hashedSenha) => {
    if (err) {
      console.error('Erro ao criptografar a senha:', err);
      return res.status(500).json({ error: 'Erro no servidor' });
    }

    const query = 'INSERT INTO usuario (email, senha) VALUES (?, ?)';
    db.query(query, [email, hashedSenha], (err, results) => {
      if (err) {
        console.error('Erro ao inserir usuário:', err);
        return res.status(500).json({ error: 'Erro no servidor' });
      }

      res.status(201).json({ message: 'Usuário criado com sucesso', userId: results.insertId });
    });
  });
});


const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Servidor Node.js rodando na porta ${PORT}`);
});
