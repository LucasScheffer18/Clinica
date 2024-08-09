const express = require('express');
const mysql = require('mysql');
const bcrypt = require('bcrypt');
const app = express();
app.use(express.json());

const db = mysql.createConnection({
    host: 'usuarios-container',
    user: 'root',
    password: 'usuariosdb',
    database: 'usuarios'
});

db.connect(err => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados:', err);
        return;
    }
    console.log('Conectado ao banco de dados de usu�rios!');
});

app.post('/login', (req, res) => {
    const { email, senha } = req.body;
    if (!email || !senha) {
        return res.status(400).send({ message: 'Email e senha s�o obrigat�rios' });
    }

    const query = 'SELECT * FROM usuario WHERE email = ?';
    db.query(query, [email], (err, results) => {
        if (err) {
            console.error('Erro ao executar a consulta:', err);
            return res.status(500).send({ message: 'Erro no servidor' });
        }

        if (results.length === 0) {
            return res.status(401).send({ message: 'Email ou senha inv�lidos' });
        }

        const user = results[0];
        bcrypt.compare(senha, user.senha, (err, isMatch) => {
            if (err) {
                console.error('Erro ao comparar senhas:', err);
                return res.status(500).send({ message: 'Erro no servidor' });
            }

            if (isMatch) {
                res.send({ message: 'Login bem-sucedido' });
            } else {
                res.status(401).send({ message: 'Email ou senha inv�lidos' });
            }
        });
    });
});

app.listen(3002, () => {
    console.log('Servi�o de login rodando na porta 3002');
});
