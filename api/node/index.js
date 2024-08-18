const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
app.use(bodyParser.json());
app.use(cors());

const db = mysql.createConnection({
    host: 'db', // Nome do servi�o do banco de dados no Docker Compose
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
            res.status(404).json({ error: 'Usu�rio n�o encontrado' });
        }
    });
});

app.get('/consultas', (req, res) => {
    const sql = `
        SELECT 
            c.consulta_id,
            c.data_consulta,
            c.paciente_id,
            p.nome AS paciente_nome,
            c.medico_id,
            m.nome AS medico_nome
        FROM 
            consultas c
        JOIN 
            pacientes p ON c.paciente_id = p.paciente_id
        JOIN 
            medicos m ON c.medico_id = m.medico_id
        ORDER BY 
            c.data_consulta DESC;
    `;

    db.query(sql, (err, results) => {
        if (err) {
            console.error('Erro ao buscar consultas:', err);
            return res.status(500).json({ error: 'Erro ao buscar consultas' });
        }
        res.status(200).json(results);
    });
});

app.delete('/consultas/:id', (req, res) => {
    const consultaId = req.params.id;

    const sql = 'DELETE FROM consultas WHERE consulta_id = ?';

    db.query(sql, [consultaId], (err, result) => {
        if (err) {
            console.error('Erro ao excluir a consulta:', err);
            return res.status(500).json({ error: 'Erro ao excluir a consulta' });
        }

        if (result.affectedRows === 0) {
            return res.status(404).json({ error: 'Consulta não encontrada' });
        }

        res.status(200).json({ message: 'Consulta excluída com sucesso' });
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


// Obter m�dicos
app.get('/medicos', (req, res) => {
    console.log('Request to get doctors received');
    const sql = 'SELECT medico_id, nome FROM medicos';
    db.query(sql, (err, results) => {
        if (err) {
            console.error('Erro ao obter m�dicos:', err);
            return res.status(500).json({ error: 'Erro ao obter m�dicos' });
        }
        console.log('Doctors query results:', results);
        res.status(200).json({ medicos: results });
    });
});


// Cadastrar consulta
app.post('/consultas', (req, res) => {
    const { data_consulta, paciente_id, medico_id } = req.body;
    console.log('Request to add consultation received:', data_consulta, paciente_id, medico_id);

    const sql = 'INSERT INTO consultas (data_consulta, paciente_id, medico_id) VALUES (?, ?, ?)';
    db.query(sql, [data_consulta, paciente_id, medico_id], (err, result) => {
        if (err) {
            console.error('Erro ao cadastrar consulta:', err);
            return res.status(500).json({ error: 'Erro ao cadastrar consulta' });
        }
        console.log('Consultation added successfully:', result);
        res.status(200).json({ success: true });
    });
});


// Cadastrar m�dico
app.post('/medicos', (req, res) => {
    const { nome, especialidade } = req.body;
    console.log('Request to add doctor received:', nome, especialidade);

    const sql = 'INSERT INTO medicos (nome, especialidade) VALUES (?, ?)';
    db.query(sql, [nome, especialidade], (err, result) => {
        if (err) {
            console.error('Erro ao cadastrar m�dico:', err);
            return res.status(500).json({ error: 'Erro ao cadastrar m�dico' });
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


// Cadastrar hist�rico
app.post('/historico', (req, res) => {
    const { diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico } = req.body;
    console.log('Request to add historical record received:', diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico);

    const sql = 'INSERT INTO historico (diagnostico, tratamento, prescricao, paciente_id, medico_id, data_historico) VALUES (?, ?, ?, ?, ?, ?)';
    db.query(sql, [diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico], (err, result) => {
        if (err) {
            console.error('Erro ao cadastrar hist�rico:', err);
            return res.status(500).json({ error: 'Erro ao cadastrar hist�rico' });
        }
        console.log('Historical record added successfully:', result);
        res.status(200).json({ success: true });
    });
});


// Obter hist�rico de diagn�sticos
app.get('/historico', (req, res) => {
    console.log('Request to get historical records received');
    const sql = `SELECT nome ,diagnostico,data_historico FROM historico,pacientes where historico.paciente_id = pacientes.paciente_id`;
    db.query(sql, (err, results) => {
        if (err) {
            console.error('Erro ao obter hist�rico de diagn�sticos:', err);
            return res.status(500).json({ error: 'Erro ao obter hist�rico de diagn�sticos' });
        }
        console.log('Historical records query results:', results);
        res.status(200).json(results);
    });
});



// Adicionar diagn�stico
app.post('/diagnostico', (req, res) => {
    const { diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico } = req.body;
    console.log('Request to add diagnosis received:', diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico);

    const sql = `
        INSERT INTO historico (diagnostico, tratamento, prescricao, paciente_id, medico_id, data_historico)
        VALUES (?, ?, ?, ?, ?, ?)
    `;
    db.query(sql, [diagnostico, tratamento, prescricao, paciente_id, medico_id, data_diagnostico], (err, result) => {
        if (err) {
            console.error('Erro ao adicionar diagn�stico:', err);
            return res.status(500).json({ error: 'Erro ao adicionar diagn�stico' });
        }
        console.log('Diagnosis added successfully:', result);
        res.status(200).json({ success: true });
    });
});

app.post('/register', (req, res) => {
  const { email, senha } = req.body;

  if (!email || !senha) {
    return res.status(400).json({ error: 'Email e senha s�o obrigat�rios' });
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
        console.error('Erro ao inserir usu�rio:', err);
        return res.status(500).json({ error: 'Erro no servidor' });
      }

      res.status(201).json({ message: 'Usu�rio criado com sucesso', userId: results.insertId });
    });
  });
});


const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Servidor Node.js rodando na porta ${PORT}`);
});
